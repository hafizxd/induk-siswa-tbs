<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
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

    public function indexUpdate() {
        return view('imports.update');
    }
}
