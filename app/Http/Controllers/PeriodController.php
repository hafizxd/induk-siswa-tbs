<?php

namespace App\Http\Controllers;

use App\Curriculum;
use App\Period;
use App\Subject;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;

class PeriodController extends Controller
{
    public function index() {
        $periods = Period::with('curriculum.curriculumScoreCols')
            ->orderBy('year', 'desc')
            ->get()
            ->groupBy('year');

        $pickedYears = Period::select('year')
            ->orderBy('year', 'desc')
            ->groupBy('year')
            ->get()
            ->flatten()
            ->pluck('year')
            ->toArray();

        $yearOptions = [];
        $currentYear = date('Y');
        for ($i = 0; $i < 10; $i++) {
            $yearOptions[] = $currentYear - $i;
        }
        $yearOptions = array_values(array_diff($yearOptions, $pickedYears));

        $curriculums = Curriculum::orderBy('created_at', 'desc')->get();

        return view('periods.index', compact('periods', 'yearOptions', 'curriculums', 'pickedYears'));
    }

    public function store(Request $request) {
        $request->validate([
            'year' => 'required',
            'curriculum_id' => 'required|exists:curriculums,id'
        ]);

        if (empty($request->year_copy)) {
            Period::insert([
                [
                    'year' => $request->year,
                    'curriculum_id' => $request->curriculum_id,
                    'class' => 'VII'
                ],
                [
                    'year' => $request->year,
                    'curriculum_id' => $request->curriculum_id,
                    'class' => 'VIII'
                ],
                [
                    'year' => $request->year,
                    'curriculum_id' => $request->curriculum_id,
                    'class' => 'IX'
                ]
            ]);

        } else {
            $periodCopies = Period::where('year', $request->year_copy)
                ->with(['subjects' => function ($q) {
                    $q->withPivot('is_col_instantiate');
                }])
                ->get();

            foreach ($periodCopies as $period) {
                $createdPeriod = Period::create([
                    'year' => $request->year,
                    'class' => $period->class,
                    'curriculum_id' => $request->curriculum_id
                ]);

                $insertSubjectData = [];
                foreach ($period->subjects as $subject) {
                    $insertSubjectData[] = [
                        'subject_id' => $subject->id,
                        'is_col_instantiate' => $subject->pivot->is_col_instantiate,
                        'period_id' => $createdPeriod->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }

                DB::table('period_subjects')->insert($insertSubjectData);
            }
        }

        Session::put('SUCCESS', 'Berhasil menyimpan periode baru');
        return redirect()->back();
    }

    public function update($periodId, Request $request) {
        $period = Period::findOrFail($periodId)
            ->update([
                'curriculum_id' => $request->curriculum_id
            ]);

        Session::put('SUCCESS', 'Berhasil mengupdate periode');
        return redirect()->back();
    }

    public function getSubjects($periodId) {
        $period = Period::findOrFail($periodId);
        $periodOpts = Period::where('id', '!=', $periodId)
            ->orderBy('year', 'desc')
            ->orderBy('class', 'desc')
            ->get();

        $assignedSubjects = $period->subjects()
            ->withPivot('is_col_instantiate')
            ->when($period->class != 'IX', function ($q) {
                $q->where('type', '!=', 'UJIAN');
            })
            ->orderBy('type', 'asc')
            ->orderBy('order_no', 'asc')
            ->get();
        $subjectIds = $assignedSubjects->pluck('id')->toArray();
        
        $unassignedSubjects = Subject::whereNotIn('id', $subjectIds)
            ->when($period->class != 'IX', function ($q) {
                $q->where('type', '!=', 'UJIAN');
            })
            ->orderBy('type', 'asc')
            ->orderBy('order_no', 'asc')
            ->get();

        return view('periods.subject', compact('period', 'periodOpts', 'assignedSubjects', 'unassignedSubjects'));
    }

    public function assignSubjects($periodId, Request $request) {
        $period = Period::findOrFail($periodId);

        $insertData = [];
        foreach ($request->subject as $key => $subject) {
            $arr = [
                'subject_id' => $key,
                'is_col_instantiate' => false,
                'period_id' => $period->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (array_key_exists($key, $request->is_col_instantiate)) {
                $arr['is_col_instantiate'] = true;
            }

            $insertData[] = $arr;
        }

        DB::beginTransaction();
        try {
            $period->subjects()->detach();
            DB::table('period_subjects')->insert($insertData);

            DB::commit();

            Session::put('SUCCESS', 'Berhasil assign mata pelajaran');
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::put('ERROR', 'Terjadi kesalahan internal');
        }

        return redirect()->back();
    }

    public function copySubjects($periodId, Request $request) {
        $request->validate([
            'copy_period_id' => 'required'
        ]);
        
        $period = Period::findOrFail($periodId);
        $copyPeriod = Period::with(['subjects' => function ($q) use ($period) {
                $q->withPivot('is_col_instantiate')
                    ->when($period->class != 'IX', function ($q) {
                        $q->where('type', '!=', 'UJIAN');
                    });
            }])
            ->findOrFail($request->copy_period_id);

        $insertData = [];
        foreach ($copyPeriod->subjects as $subject) {
            $insertData[] = [
                'subject_id' => $subject->id,
                'is_col_instantiate' => $subject->pivot->is_col_instantiate,
                'period_id' => $period->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        
        DB::beginTransaction();
        try {
            $period->subjects()->detach();
            DB::table('period_subjects')->insert($insertData);

            DB::commit();

            Session::put('SUCCESS', 'Berhasil copy mata pelajaran periode ' . $copyPeriod->year . ' - ' . $copyPeriod->class );
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Session::put('ERROR', 'Terjadi kesalahan internal');
        }

        return redirect()->back();
    }
}
