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
    public function index(Request $request)
    {
        $subjects = Subject::all();

        return view('grades.index', compact('subjects'));
    }

    public function datatables(Request $request)
    {
        $subjects = Subject::all();
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
            ->addColumn('action', function ($student) {
                return '<a href="'.route('students.edit', $student->id).'" class="btn btn-outline-warning btn-xs rounded"><i class="fa fa-edit"></i></a>';
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

    public function create()
    {
        return view('students.create');
    }

    public function store(CreateStudentRequest $request)
    {
        $input = $request->all();
        $isExists = Student::where('nis', $input['nis'])->exists();
        if ($isExists) {
            Session::put('ERROR', 'NIS sudah pernah terdaftar.');
            return redirect()->back()->withInput();
        }

        $siswaInfo = $input['siswa'];
        $siswaInfo['type'] = 'SISWA';

        $ayah = $input['ayah'];
        $ayah['type'] = 'AYAH';
        $ayah['tanggal_lahir'] = convertDateFormat($ayah['tanggal_lahir'], 'm/d/Y');

        $ibu = $input['ibu'];
        $ibu['type'] = 'IBU';
        $ibu['tanggal_lahir'] = convertDateFormat($ibu['tanggal_lahir'], 'm/d/Y');

        $wali = $input['wali'];
        $wali['type'] = 'WALI';
        $wali['tanggal_lahir'] = convertDateFormat($wali['tanggal_lahir'], 'm/d/Y');

        unset($input['_token']);
        unset($input['siswa']);
        unset($input['ayah']);
        unset($input['ibu']);
        unset($input['wali']);

        $input['tanggal_lahir'] = convertDateFormat($input['tanggal_lahir'], 'm/d/Y');
        $student = Student::create($input);

        $student->relationInfos()->createMany([ 
            $siswaInfo,
            $ayah,
            $ibu,
            $wali   
        ]);

        Session::put('SUCCESS', 'Student saved successfully.');

        return redirect(route('students.index'));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);

        return view('students.show')->with('student', $student);
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        return view('students.edit')->with('student', $student);
    }

    public function update($id, UpdateStudentRequest $request)
    {
        $student = Student::findOrFail($id);

        Session::put('SUCCESS', 'Student updated successfully.');

        return redirect(route('students.index'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        $student->delete();

        Session::put('SUCCESS', 'Student deleted successfully.');

        return redirect(route('students.index'));
    }
}
