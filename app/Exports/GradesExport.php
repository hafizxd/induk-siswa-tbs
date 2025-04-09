<?php

namespace App\Exports;

use App\Period;
use App\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use stdClass;


class GradesExport extends StringValueBinder implements FromArray, WithHeadings, WithEvents, ShouldAutoSize
{
    private $request;
    private $period;
    private $students;
    private $mergeHeaderCols;
    private $lastColIdx;
    private $headerPlaceholders;

    public function __construct(Request $request, Period $period, $students)
    {
        $this->request = $request;
        $this->period = $period;
        $this->students = $students;
    }

    public function headings(): array
    {
        $this->headerPlaceholders = [];
        $dynamicHeaderStartCol = 4;
        $smtColIdx = $dynamicHeaderStartCol;
        $subjectColIdx = $dynamicHeaderStartCol;

        $header = [
            ['Nama Siswa', 'NIS', ''],
            ['', '', '']
        ];

        $scoreCols = $this->period->curriculum->curriculumScoreCols->pluck('name')->toArray();
        $scoreColIds = $this->period->curriculum->curriculumScoreCols->pluck('id')->toArray();
        if (count($scoreCols) > 1) {
            $header[] = ['', '', ''];
        }

        // Semester 1 & 2
        for($i = 1; $i <= 2; $i++) {
            $smtHeadStr = 'SEMESTER ' . $i;

            // Pad Count
            // Jumlah kolom setelah initial value yg akan di merge
            $smtPadCount = 0;

            foreach ($this->period->subjects as $key => $subject) {
                if ($subject->type == 'UJIAN' && ($this->period->class != 'IX' || $i != 2))
                    continue;

                // Children Col Count
                // Jumlah kolom header row paling bawah atau anak dari Subject, minimal 1
                $childrenColCount = 1;

                if (count($scoreCols) > 1) {
                    if ($subject->pivot->is_col_instantiate) {
                        $header[2] = array_merge($header[2], $scoreCols);
                        $childrenColCount = count($scoreCols);
                        $this->headerPlaceholders[$i][$subject->id] = $scoreColIds;
                    } else {
                        $header[2][] = $scoreCols[0];
                        $this->headerPlaceholders[$i][$subject->id] = [$scoreColIds[0]];
                    }
                } else {
                    $this->headerPlaceholders[$i][$subject->id] = [$scoreColIds[0]];
                }

                $subjectPadCount = $childrenColCount - 1;
                $subjectName = $subject->type == 'UJIAN' ? 'UJIAN_'.$subject->name : $subject->name;

                $header[1] = array_merge($header[1], $this->addArrPadding($subjectName, $subjectPadCount));

                $this->mergeHeaderCols[] = $this->numberToExcelColumn($subjectColIdx).'2:'.$this->numberToExcelColumn($subjectColIdx + $subjectPadCount).'2';
                $subjectColIdx += ($subjectPadCount + 1);

                if ($key > 0)
                    $smtPadCount++;
                $smtPadCount += $subjectPadCount;
            }

            $header[0] = array_merge( $header[0], $this->addArrPadding($smtHeadStr, $smtPadCount));
            
            $this->mergeHeaderCols[] = $this->numberToExcelColumn($smtColIdx).'1:'.$this->numberToExcelColumn($smtColIdx + $smtPadCount).'1';
            $smtColIdx += ($smtPadCount + 1);
        }

        // dd($this->mergeHeaderCols);
        $this->lastColIdx = $smtColIdx - 1;

        return $header;
    }

    public function array(): array
    {
        // Count column count for student row
        $padCols = [];
        foreach ($this->headerPlaceholders as $semester => $subjects) {
            foreach ($subjects as $subjectId => $cols) {
                foreach ($cols as $col) {
                    $padCols[] = '';
                }
            }
        }

        $studentRows = [];
        foreach ($this->students as $student) {
            $loopCount = 0;            
            $row = $padCols;

            foreach ($this->headerPlaceholders as $semester => $subjects) {
                $studentSemester = $student->scores
                    ->filter(function ($q) use ($semester) {
                        return $q->semester == $semester;
                    })
                    ->first();

                foreach ($subjects as $subjectId => $cols) {
                    $studentSubject = null;
                    if (!empty($studentSemester)) {
                        $studentSubject = $studentSemester->scoreSubjects
                            ->filter(function ($q) use ($subjectId) {
                                return $q->subject_id == $subjectId;
                            })
                            ->first();
                    }

                    foreach ($cols as $col) {
                        $studentCol = null;
                        if (!empty($studentSubject)) {
                            $studentCol = $studentSubject->scoreCols
                                ->filter(function ($q) use ($col) {
                                    return $q->curriculum_col_id == $col;
                                })
                                ->first();

                            if (!empty($studentCol)) {
                                $row[$loopCount] = $studentCol->score;
                            }
                        }
                            
                        $loopCount++;
                    }
                }
            }

            $row = array_merge([$student->nama_lengkap, $student->nis, ''], $row);
            $studentRows[] = $row;
        }

        return $studentRows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                
                $latestCol = $this->numberToExcelColumn($this->lastColIdx);
                $latestRow = (count($this->period->curriculum->curriculumScoreCols) <= 1) ? '2' : '3';

                // Merge Nama & NIS
                $sheet->mergeCells('A1:A'.$latestRow);
                $sheet->mergeCells('B1:B'.$latestRow);

                // Merge Subjects
                foreach ($this->mergeHeaderCols as $cells) {
                    $sheet->mergeCells($cells);
                }

                $range = 'A1:'.$latestCol.$latestRow;

                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true, // Bold all text
                    ],
                ]);
            },
        ];
    }

    private function addArrPadding($initial, $padCount) : array {
        $arr = [$initial];
        for ($i = 0; $i < $padCount; $i++) {
            $arr[] = '';
        }

        return $arr;
    }

    private function numberToExcelColumn($number) : string {
        $column = '';

        while ($number > 0) {
            $number--;
            $column = chr(65 + ($number % 26)) . $column;
            $number = intval($number / 26);
        }

        return $column;
    }
}
