<?php

namespace App\Http\Controllers;

use App\Imports\GradeImport;
use App\Imports\GradeUpdateImport;
use App\Imports\StudentImport;
use App\Imports\StudentUpdateImport;
use App\Period;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ImportController extends Controller
{
    public function index() {
        return view('imports.index');
    }

    public function upload(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new StudentImport, request()->file('file'));
        Session::put('SUCCESS', 'Berhasil menyimpan data import');
        return redirect()->back();
    }

    public function uploadUpdate(Request $request) {
        $request->validate([
            'file_update' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new StudentUpdateImport, request()->file('file_update'));
        Session::put('SUCCESS', 'Berhasil menyimpan data import');
        return redirect()->back();
    }

    public function gradeIndex(Request $request) {
        $periods = Period::orderBy('year', 'desc')
            ->get()
            ->groupBy('year');

        if (!isset($request->period_id) || empty($request->period_id)) {
            return view('imports.grade-select', compact('periods'));    
        }

        $selectedPeriod = Period::findOrFail($request->period_id);

        return view('imports.grade-index', compact('periods', 'selectedPeriod'));
    }

    public function gradeUpload(Request $request, $periodId) {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $period = Period::with(['curriculum.curriculumScoreCols' => function ($q) {
                $q->orderBy('order_no', 'asc');
            }])
            ->with(['subjects' => function ($q) {
                $q->orderBy('type', 'asc')
                    ->orderBy('order_no', 'asc')
                    ->withPivot('is_col_instantiate');
            }])
            ->findOrFail($periodId);

        Excel::import((new GradeImport($request, $period)), request()->file('file'));
        Session::put('SUCCESS', 'Berhasil menyimpan data import');
        return redirect()->back();
    }

    public function gradeUploadUpdate(Request $request, $periodId) {
        $request->validate([
            'file_update' => 'required|mimes:xls,xlsx'
        ]);

        $period = Period::with(['curriculum.curriculumScoreCols' => function ($q) {
                $q->orderBy('order_no', 'asc');
            }])
            ->with(['subjects' => function ($q) {
                $q->orderBy('type', 'asc')
                    ->orderBy('order_no', 'asc')
                    ->withPivot('is_col_instantiate');
            }])
            ->findOrFail($periodId);

        Excel::import(new GradeUpdateImport($request, $period), request()->file('file_update'));
        Session::put('SUCCESS', 'Berhasil menyimpan data import');
        return redirect()->back();
    }
}
