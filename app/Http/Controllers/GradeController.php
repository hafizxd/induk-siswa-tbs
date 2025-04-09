<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Period;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;
use Flash;
use Session;
use Response;
use DataTables;
use Carbon\Carbon;
use stdClass;

class GradeController extends Controller
{
    public function index($type, Request $request)
    {
        $periods = Period::orderBy('year', 'desc')
            ->get()
            ->groupBy('year');

        $period = Period::with(['curriculum.curriculumScoreCols' => function ($q) {
                $q->orderBy('order_no', 'asc');
            }])
            ->with(['subjects' => function ($q) use ($type) {
                $q->where('type', $type)
                    ->orderBy('order_no', 'asc')
                    ->withPivot('is_col_instantiate');
            }]);

        if (empty($request->period_id)) {
            $period = $period->orderBy('year', 'desc')->orderBy('class', 'asc')->firstOrFail();
        } else {
            $period = $period->findOrFail($request->period_id);
        }
            

        $classColName = '';
        $absColName = '';
        switch ($period->class) {
            case 'VII': 
                $classColName = 'kelas_7';
                $absColName = 'abs_7';
                break;
            case 'VIII': 
                $classColName = 'kelas_8';
                $absColName = 'abs_8';
                break;
            case 'IX': 
                $classColName = 'kelas_9';
                $absColName = 'abs_9';
                break;
        }
            
        $students = Student::select('id', 'nis', 'nama_lengkap')
            ->whereHas('scores', function ($q) use ($period) {
                $q->where('period_id', $period->id);
            })
            ->with(['scores' => function ($q) use ($period) {
                $q->where('period_id', $period->id)
                    ->orderBy('semester')
                    ->with('scoreSubjects.scoreCols');
            }])
            ->when(!empty($request->class), function ($q) use ($request, $classColName) {
                if (!empty($classColName))
                    $q->where($classColName, $request->class);
            })
            ->orderBy('tahun_masuk', 'desc')
            ->orderBy($classColName)
            ->orderBy($absColName)
            ->get();


        $headerTable = [ [], [], [] ];
        $headerForMap = [];

        $scoreCols = $period->curriculum->curriculumScoreCols->pluck('name')->toArray();
        $scoreColIds = $period->curriculum->curriculumScoreCols->pluck('id')->toArray();
        
        $i = 1;
        if ($type == 'UJIAN')
            $i = 2;

        for($i; $i <= 2; $i++) {
            $smtColspan = 0;

            foreach ($period->subjects as $key => $subject) {
                if ($subject->type == 'UJIAN' && ($period->class != 'IX' || $i != 2)) 
                    continue;

                $subjectColspan = 1;

                if (count($scoreCols) > 1) {
                    if ($subject->pivot->is_col_instantiate) {
                        $headerTable[2] = array_merge($headerTable[2], $scoreCols);
                        $subjectColspan = count($scoreCols);
                        $headerForMap[$i][$subject->id] = $scoreColIds;
                    } else {
                        $headerTable[2][] = $scoreCols[0];
                        $headerForMap[$i][$subject->id] = [$scoreColIds[0]];
                    }
                } else {
                    $headerForMap[$i][$subject->id] = [$scoreColIds[0]];
                }

                $headerTable[1][] = [
                    'text' => $subject->name,
                    'colspan' => $subjectColspan
                ];

                $smtColspan += $subjectColspan;
            }

            $headerTable[0][] = [
                'text' => 'Semester ' . $i,
                'colspan' => $smtColspan
            ];
        }

        $padCols = [];
        foreach ($headerForMap as $semester => $subjects) {
            foreach ($subjects as $subjectId => $cols) {
                foreach ($cols as $col) {
                    $padCols[] = '';
                }
            }
        }

        foreach ($students as $key => $student) {
            $loopCount = 0;
            $row = $padCols;

            foreach ($headerForMap as $semester => $subjects) {
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

            $students[$key]->mappedScores = $row;
        }

        return view('grades.index', compact('students', 'periods', 'period', 'headerTable'));
    }

    public function editGrade(Request $request, $id, $class) {
        $student = Student::select('id', 'nama_lengkap')->findOrFail($id);

        $scores = $student->scores()
            ->whereHas('period', function ($q) use ($class) {
                $q->where('class', convertClassNumRoman($class));
            })
            ->with('scoreSubjects.scoreCols')
            ->get();

        if (count($scores) == 0) {
            $periods = Period::where('class', convertClassNumRoman($class))
                ->orderBy('year', 'desc')
                ->get();
            return view('students.edit.select-grade', compact('student', 'periods'));
        }

        $period = Period::where('id', $scores[0]->period->id)
            ->with(['subjects' => function ($q) {
                $q->where('type', 'RAPOR')
                    ->orderBy('order_no', 'asc')
                    ->withPivot('is_col_instantiate');
            }])
            ->with('curriculum.curriculumScoreCols')
            ->first();

        $subjectPlaceholders = [];

        for ($i=1; $i<=2; $i++) {
            $subjectPlaceholders[$i] = [];

            $score = $scores->first(function ($item) use ($i) {
                    return $item->semester == $i;
                });

            foreach ($period->subjects as $subject) {
                $subjectPlaceholders[$i][$subject->id] = [
                    'subject_name' => $subject->name,
                    'scores' => []
                ];
                
                $scoreSubject = null;
                if (!empty($score)) {
                    $scoreSubject = $score->scoreSubjects->first(function ($item) use ($subject) {
                            return $item->subject_id == $subject->id;
                        });
                }

                if ($subject->pivot->is_col_instantiate) {
                    foreach ($period->curriculum->curriculumScoreCols as $curScoreCol) {

                        $scoreCol = null;
                        if (!empty($scoreSubject)) {
                            $scoreCol = $scoreSubject->scoreCols->first(function ($item) use ($curScoreCol) {
                                return $item->curriculum_col_id == $curScoreCol->id;
                            });
                        }

                        $scoreResult = null;
                        if (!empty($scoreCol))
                            $scoreResult = $scoreCol->score;

                        $subjectPlaceholders[$i][$subject->id]['scores'][$curScoreCol->id] = $scoreResult;
                    }
                } else {
                    if (empty($period->curriculum->curriculumScoreCols))
                        continue;

                    $firstCol = $period->curriculum->curriculumScoreCols[0];

                    $scoreCol = null;
                    if (!empty($scoreSubject)) {
                        $scoreCol = $scoreSubject->scoreCols->first(function ($item) use ($firstCol) {
                            return $item->curriculum_col_id == $firstCol->id;
                        });
                    }

                    $scoreResult = null;
                    if (!empty($scoreCol))
                        $scoreResult = $scoreCol->score;

                    $subjectPlaceholders[$i][$subject->id]['scores'][$firstCol->id] = $scoreResult;
                }
            }
        }

        return view('students.edit.edit-grade', compact('student', 'period', 'subjectPlaceholders'));
    }

    public function editGradeUjian(Request $request, $id) {
        $student = Student::select('id', 'nama_lengkap')->findOrFail($id);

        $scores = $student->scores()
            ->whereHas('period', function ($q) {
                $q->where('class', 'IX');
            })
            ->with('scoreSubjects.scoreCols')
            ->get();

        if (count($scores) == 0) {
            $periods = Period::where('class', 'IX')
                ->orderBy('year', 'desc')
                ->get();
            return view('students.edit.select-grade', compact('student', 'periods'));
        }

        $period = Period::where('id', $scores[0]->period->id)
            ->with(['subjects' => function ($q) {
                $q->where('type', 'UJIAN')
                    ->orderBy('order_no', 'asc')
                    ->withPivot('is_col_instantiate');
            }])
            ->with('curriculum.curriculumScoreCols')
            ->first();

        $subjectPlaceholders = [];

        $score = $scores->first(function ($item) {
                return $item->semester == 2;
            });

        foreach ($period->subjects as $subject) {
            $subjectPlaceholders[$subject->id] = [
                'subject_name' => $subject->name,
                'scores' => []
            ];
            
            $scoreSubject = null;
            if (!empty($score)) {
                $scoreSubject = $score->scoreSubjects->first(function ($item) use ($subject) {
                        return $item->subject_id == $subject->id;
                    });
            }

            if ($subject->pivot->is_col_instantiate) {
                foreach ($period->curriculum->curriculumScoreCols as $curScoreCol) {

                    $scoreCol = null;
                    if (!empty($scoreSubject)) {
                        $scoreCol = $scoreSubject->scoreCols->first(function ($item) use ($curScoreCol) {
                            return $item->curriculum_col_id == $curScoreCol->id;
                        });
                    }

                    $scoreResult = null;
                    if (!empty($scoreCol))
                        $scoreResult = $scoreCol->score;

                    $subjectPlaceholders[$subject->id]['scores'][$curScoreCol->id] = $scoreResult;
                }
            } else {
                if (empty($period->curriculum->curriculumScoreCols))
                    continue;

                $firstCol = $period->curriculum->curriculumScoreCols[0];

                $scoreCol = null;
                if (!empty($scoreSubject)) {
                    $scoreCol = $scoreSubject->scoreCols->first(function ($item) use ($firstCol) {
                        return $item->curriculum_col_id == $firstCol->id;
                    });
                }

                $scoreResult = null;
                if (!empty($scoreCol))
                    $scoreResult = $scoreCol->score;

                $subjectPlaceholders[$subject->id]['scores'][$firstCol->id] = $scoreResult;
            }
        }

        return view('students.edit.edit-grade-ujian', compact('student', 'period', 'subjectPlaceholders'));
    }

    public function assignPeriod(Request $request, $id) {
        $request->validate([
            'period_id' => 'required',
            'class' => 'required|in:7,8,9'
        ]);

        $period = Period::select('id')
            ->where('class', convertClassNumRoman($request->class))
            ->firstOrFail();

        $student = Student::select('id')->findOrFail($id);
        $student->scores()->create([
            'period_id' => $period->id,
            'semester' => 1,
            'semester_score' => 0
        ], [
            'period_id' => $period->id,
            'semester' => 2,
            'semester_score' => 0
        ]);

        Session::put('SUCCESS', 'Berhasil assign periode');
        return redirect()->back();
    }

    public function updateGrade(Request $request, $id) {
        $request->validate([
            'semester' => 'nullable|array',
            'semester.*.*.*' => 'nullable|numeric',
            'period_id' => 'required|exists:periods,id'
        ]);

        $student = Student::select('id', 'nama_lengkap')->findOrFail($id);

        foreach ($request->semester as $semester => $subjects) {
            $studentScore = $student->scores()->firstOrCreate([
                'semester' => $semester,
                'period_id' => $request->period_id
            ], [
                'semester_score' => 0
            ]);

            foreach ($subjects as $subjectId => $cols) {
                $scoreSubject = $studentScore->scoreSubjects()->firstOrCreate([
                    'subject_id' => $subjectId
                ]);

                foreach ($cols as $colId => $score) {
                    if (!isset($score))
                        continue;

                    $scoreSubject->scoreCols()->updateOrCreate([
                        'curriculum_col_id' => $colId,  
                    ], [
                        'score' => $score
                    ]);
                }
            }
        }

        Session::put('SUCCESS', 'Berhasil menyimpan nilai');
        return redirect()->back();
    }
}
