<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;
use Flash;
use Session;
use Response;
use DataTables;
use Carbon\Carbon;

class GradeController extends Controller
{
    public function index($type, Request $request)
    {
        $subjects = Subject::where('type', strtoupper($type))->get();

        return view('grades.index', compact('subjects'));
    }

    public function datatables($type, Request $request)
    {
        $subjects = Subject::where('type', strtoupper($type))->get();
        $students = Student::query()->with('scores.scoreSubjects');

        if (!empty($request->masukStart)) {
            $students->where('tahun_masuk', '>=', $request->masukStart);
        }
        if (!empty($request->masukEnd)) {
            $students->where('tahun_masuk', '<=', $request->masukEnd);
        }
        if (!empty($request->mutasiStart)) {
            $students->where('tahun_mutasi', '>=', $request->mutasiStart);
        }
        if (!empty($request->mutasiEnd)) {
            $students->where('tahun_mutasi', '<=', $request->mutasiEnd);
        }
        if (!empty($request->class)) {
            $arrClass = explode('-', $request->class);
            $kelas = $arrClass[0];
            $kelompok = $arrClass[1];
            $students->where('kelas_'.$kelas, $kelompok);
        }

        $datatable = DataTables::of($students)
            ->addIndexColumn()
            ->editColumn('nama_lengkap', function($data) {
                return '<b>'.$data->nama_lengkap.'</b>';
            })
            ->addColumn('action', function ($student) use ($type) {
                return '<a href="'.route('students.edit_grade', ['id' => $student->id, 'type' => $type]).'" class="btn btn-outline-warning btn-xs rounded"><i class="fa fa-edit"></i></a>';
            });

        foreach ($subjects as $subject) {
            $datatable = $datatable->addColumn($subject->name, function ($student) use ($subject) {
                $subjectScore = '-';

                foreach ($student->scores as $score) {
                    foreach ($score->scoreSubjects as $scoreSubject) {
                        if ($scoreSubject->subject_id == $subject->id) {
                            $subjectScore = $scoreSubject->nilai;
                            break;
                        }
                    }
                    if ($subjectScore != '-') {
                        break;
                    }
                }

                return $subjectScore;
            });
        }

        $datatable = $datatable->rawColumns(array_merge($subjects->pluck('name')->toArray(), ['nama_lengkap', 'action']));

        return $datatable->make();
    }

    public function update($type, $id, Request $request)
    {
        $request->validate([
            'scores' => 'required|array'
        ]);

        $student = Student::findOrFail($id);
        $score = $student->scores()->firstOrCreate(['student_id' => $student->id]);

        foreach ($request->scores as $sbjId => $updScore) {
            if ($updScore != null) {
                $score->scoreSubjects()->updateOrCreate([
                    'subject_id' => $sbjId
                ], [
                    'nilai' => $updScore
                ]);
            }
        }

        Session::put('SUCCESS', 'Grade updated successfully.');

        return redirect()->back();
    }
}
