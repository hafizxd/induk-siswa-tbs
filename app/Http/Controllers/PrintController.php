<?php

namespace App\Http\Controllers;

use App\Period;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function student($studentId) {
        $student = Student::with(['relationInfos'])->findOrFail($studentId);
        foreach ($student->relationInfos as $rel) {
            $relationAyah = [];
            $relationIbu = [];
            $relationWali = [];
            $relationSiswa = [];
            foreach ($student->relationInfos as $rel) {
                switch ($rel->type) {
                    case 'AYAH':
                        $relationAyah = $rel;
                        break;

                    case 'IBU':
                        $relationIbu = $rel;
                        break;

                    case 'WALI':
                        $relationWali = $rel;
                        break;

                    case 'SISWA':
                        $relationSiswa = $rel;
                        break;
                }
            }
        }

        return view('prints.student', compact(
            'student', 
            'relationAyah', 
            'relationIbu', 
            'relationWali', 
            'relationSiswa'
        ));
    }

    public function grade($studentId) {
        // $subjects = Subject::whereHas()
        $student = Student::findOrFail($studentId);

        $periods = Period::whereHas('scores', function ($q) use ($student) {
                $q->where('student_id', $student->id);  
            })
            ->orderBy('year')
            ->get();

        $studentScores = $student->scores()
            ->with('period', 'scoreSubjects.scoreCols')
            ->get();
        // dd($studentScores);

        $classes = ['VII', 'VIII', 'IX'];
        $semesters = [1, 2];

        $placeholders = [];
        foreach ($classes as $class) {
            $placeholders[$class] = [];

            foreach ($semesters as $semester) {
                $placeholders[$class][$semester] = [];

                $temp = $studentScores->filter(function ($item) use ($class, $semester) {
                    return $item->period->class == $class && $item->semester == $semester;
                });
                if (count($temp) > 0) {
                    $scoreSubjects = $temp->first()->scoreSubjects->map(function ($item) {
                        $avg = $item->scoreCols->avg('score');
                        $item['score'] = (fmod($avg, 1) == 0) ? (int) $avg : number_format($avg, 2);
                        return $item;
                    });

                    $placeholders[$class][$semester] = $scoreSubjects;
                }
            }
        }

        $subjects = Subject::whereHas('periods', function ($q) use ($student) {
                $q->whereHas('scores', function ($q) use ($student) {
                    $q->where('student_id', $student->id);  
                });
            })
            ->where('type', 'RAPOR')
            ->orderBy('order_no')
            ->get();

        
        foreach ($subjects as $key => $subject) {
            $subjectColScores = [];
            $sumScore = 0;
            $countScore = 0;

            foreach ($classes as $class) {
                foreach ($semesters as $semester) {
                    $temp = null;

                    foreach ($placeholders[$class][$semester] as $score) {
                        if ($score->subject_id == $subject->id) {
                            $temp = $score->score;
                            $sumScore += $temp;

                            if (isset($score->score))
                                $countScore++;
                        }
                    }

                    $subjectColScores[] = $temp;
                }
            } 

            $temp = $sumScore == 0 ? 0 : $sumScore / $countScore;
            $subjectColScores[] = (fmod($temp, 1) == 0) ? (int) $temp : number_format($temp, 2);

            $subjects[$key]->scores = collect($subjectColScores);
        }

        return view('prints.grade', compact('student', 'subjects'));
    }
}
