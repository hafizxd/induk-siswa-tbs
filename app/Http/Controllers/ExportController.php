<?php

namespace App\Http\Controllers;

use App\Exports\GradesExportTemplate;
use App\Exports\GradesExport;
use App\Exports\StudentsExport;
use App\Period;
use App\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ExportController extends Controller
{
    public function student(Request $request) {
        return (new StudentsExport($request))->download('Data Siswa (' . date("YmdHis") . ').xlsx');
    }

    public function studentTemplate(Request $request) {
        $path = public_path('export/templates/template_student.xlsx');

        if (!file_exists($path)) {
            Session::put('ERROR', 'File template tidak ditemukan');
            return redirect()->back();
        }

        return response()->download($path);
    }

    public function grade(Request $request, $periodId) {
        $period = Period::with(['curriculum.curriculumScoreCols' => function ($q) {
                $q->orderBy('order_no', 'asc');
            }])
            ->with(['subjects' => function ($q) {
                $q->orderBy('type', 'asc')
                    ->orderBy('order_no', 'asc')
                    ->withPivot('is_col_instantiate');
            }])
            ->findOrFail($periodId);

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
            ->when(!empty($request->classes), function ($q) use ($request, $classColName) {
                if (!empty($classColName))
                    $q->whereIn($classColName, $request->classes);
            })
            ->orderBy('tahun_masuk', 'desc')
            ->orderBy($classColName)
            ->orderBy($absColName)
            ->get();

        $excel = new GradesExport($request, $period, $students);

        return Excel::download($excel, 'Nilai Periode '. $period->class .'-'. $period->year .'_'. ($period->year+1) .' (' . date("YmdHis") . ').xlsx');
    }

    public function gradeTemplate(Request $request, $periodId) {
        $period = Period::with(['curriculum.curriculumScoreCols' => function ($q) {
                $q->orderBy('order_no', 'asc');
            }])
            ->with(['subjects' => function ($q) {
                $q->orderBy('type', 'asc')
                    ->orderBy('order_no', 'asc')
                    ->withPivot('is_col_instantiate');
            }])
            ->findOrFail($periodId);

        $excel = new GradesExportTemplate($request, $period);

        return Excel::download($excel, 'Template Nilai Periode '. $period->class .'-'. $period->year .'_'. ($period->year+1) .' (' . date("YmdHis") . ').xlsx');
    }

}