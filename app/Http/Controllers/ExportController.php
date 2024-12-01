<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Imports\StudentImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ExportController extends Controller
{
    public function index(Request $request) {
        return (new StudentsExport($request))->download('Data Siswa (' . date("YmdHis") . ').xlsx');
    }
}