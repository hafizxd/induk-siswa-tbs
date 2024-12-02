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

class StudentController extends Controller
{
    public function index(Request $request)
    {
        return view('students.index');
    }

    public function datatables(Request $request)
    {
        $students = Student::query();

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

        return DataTables::of($students)
            ->addIndexColumn()
            ->editColumn('nama_lengkap', function($data) {
                return '<b>'.$data->nama_lengkap.'</b>';
            })
            ->editColumn('tanggal_lahir', function($data) {
                return isset($data->tanggal_lahir) ? $data->tanggal_lahir->format('d/m/Y') : null;
            })
            ->editColumn('kelas_7', function($data) {
                return "7".$data->kelas_7 . " - " . $data->abs_7;
            })
            ->editColumn('kelas_8', function($data) {
                return "8".$data->kelas_8 . " - " . $data->abs_8;
            })
            ->editColumn('kelas_9', function($data) {
                return "9".$data->kelas_9 . " - " . $data->abs_9;
            })
            ->addColumn('action', function ($student) {
                return '
                    <a href="'.route('students.edit', $student->id).'" class="btn btn-outline-warning btn-xs rounded"><i class="fa fa-edit"></i></a>
                    <button onclick="$(`#formDelete'.$student->id.'`).submit();" class="btn btn-outline-danger btn-xs rounded"><i class="fa fa-trash-o"></i></button>
                    <form id="formDelete'.$student->id.'" method="POST" action="'.route('students.delete', $student->id).'">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                    </form>
                ';
            })
            ->rawColumns(['nama_lengkap', 'action'])
            ->make();
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
        $student = Student::with(['relationInfos'])->findOrFail($id);
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

        $subjects = Subject::with(['scoreSubjects' => function ($q) use ($student) {
            $q->whereHas('score', function ($q2) use ($student) {
                $q2->where('student_id', $student->id);
            });
        }])->get();

        return view('students.edit', compact(
            'student', 
            'relationAyah', 
            'relationIbu', 
            'relationWali', 
            'relationSiswa',
            'subjects'
        ));
    }

    public function update($id, UpdateStudentRequest $request)
    {
        $student = Student::findOrFail($id);

        $input = $request->all();

        $isExists = Student::where('nis', $input['nis'])->where('id', '!=', $id)->exists();
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
        $student->update($input);

        $arr = [ $siswaInfo, $ayah, $ibu, $wali ];
        foreach ($arr as $val) {
            $student->relationInfos()->where('type', $val['type'])->update($val);
        }

        Session::put('SUCCESS', 'Student updated successfully.');

        return redirect(route('students.edit', $student->id));
    }

    public function updateScore($id, Request $request) {
        return redirect()->back();
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        $student->delete();

        Session::put('SUCCESS', 'Student deleted successfully.');

        return redirect()->back();
    }
}
