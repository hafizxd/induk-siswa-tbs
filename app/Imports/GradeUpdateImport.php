<?php

namespace App\Imports;

use App\Period;
use App\Student;
use App\Subject;
use DB;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use stdClass;

class GradeUpdateImport implements ToCollection, WithEvents
{
    use RegistersEventListeners;

    private $request;
    private $period;
    private $headers;
    private $isMultipleScoreCol;
    

    public function __construct(Request $request, Period $period) {
        $this->request = $request;
        $this->period = $period;
    }

    public function collection(Collection $rows)
    {
        $rows = $rows->slice($this->isMultipleScoreCol ? 3 : 2);
        
        foreach ($rows as $row) {
            $nis = $row[1];
            $student = Student::where('nis', $nis)
                ->select('id')
                ->first();

            if (empty($student)) 
                continue;

            $row = $row->slice(3)->values();

            $studentScore = null;

            foreach ($row as $key => $val) {
                if (empty($val))
                    continue;

                $header = $this->headers[$key];

                if (empty($studentScore) || $studentScore->semester != $header['semester']) {
                    $studentScore = $student->scores()->firstOrCreate([
                        'semester' => $header['semester'],
                        'period_id' => $this->period->id
                    ], [
                        'semester_score' => 0
                    ]);
                }

                $scoreSubject = $studentScore->scoreSubjects()->firstOrCreate([
                    'subject_id' => $header['subject_id']
                ]);

                $scoreSubject->scoreCols()->updateOrCreate([
                    'curriculum_col_id' => $header['col_id'],
                ], [
                    'score' => $val
                ]);
            }
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $arrScoreCols = $this->period
                    ->curriculum
                    ->curriculumScoreCols
                    ->pluck('name', 'id')
                    ->toArray();

                $this->isMultipleScoreCol = count($arrScoreCols) > 1;
                $latestHeaderRowIndex = $this->isMultipleScoreCol ? 3 : 2;

                $flattedHeaders = [];

                $cachedSubject = null;
                $cachedSemester = '';

                for ($col = 'D'; $col <= 'ZZZ'; $col++) {
                    $cellValue = $sheet->getCell("{$col}{$latestHeaderRowIndex}")->getValue();
                    if ($cellValue == null)
                        break;

                    // Determine Score Col Id
                    $scoreColId = ($this->isMultipleScoreCol) ? array_search($cellValue, $arrScoreCols) : $arrScoreCols[0]['id'];
                    
                    // Determine Subject
                    $subjectCell = $sheet->getCell("{$col}2")->getValue();
                    if (!empty($subjectCell)) {
                        $subject = $this->findOrNewSubject($subjectCell);
                        $cachedSubject = $subject;
                    } else {
                        $subject = $cachedSubject;
                    }

                    // Determine Semester
                    $semesterCell = $sheet->getCell("{$col}1")->getValue();
                    if (!empty($semesterCell)) {
                        $semester = substr($semesterCell, -1);
                        $cachedSemester = $semester;
                    } else {
                        $semester = $cachedSemester;
                    }

                    if (!isset($subject))
                        continue;

                    $flattedHeaders[] = [
                        'col_id' => $scoreColId,
                        'subject_id' => $subject->id,
                        'semester' => (int)$semester
                    ];
                }

                $this->headers = $flattedHeaders;
            },
        ];
    }

    private function findOrNewSubject(string $subjectCell) : Subject {
        // Cek jika mapel adalah mapel UJIAN
        $subjectType = 'RAPOR';
        if ($this->period->class == 'IX' && (strpos($subjectCell, 'UJIAN_') !== false)) {
            $subjectCell = str_replace('UJIAN_', '', $subjectCell);
            $subjectType = 'UJIAN';
        }

        $subject = Subject::where('name', $subjectCell)
            ->where('type', $subjectType)
            ->select('id')
            ->first();

        if (!isset($subject)) {
            $latestSubject = Subject::where('type', $subjectType)
                ->latest('order_no')
                ->select('order_no')
                ->first();

            $subject = Subject::create([
                'name' => $subjectCell,
                'type' => $subjectType,
                'order_no' => isset($latestSubject) ? ($latestSubject->order_no + 1) : 1
            ]);

            $subject->periods()->attach($this->period->id, ['is_col_instantiate' => true]);
        }

        return $subject;
    }
}
