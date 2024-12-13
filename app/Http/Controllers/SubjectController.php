<?php

namespace App\Http\Controllers;

use DataTables;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index()
    {
        return view('subjects.index');
    }

    public function datatables($type, Request $request)
    {
        $subjects = Subject::query()->where('type', strtoupper($type));

        return DataTables::of($subjects)
            ->addIndexColumn()
            ->addColumn('action', function ($subject) {
                $action = '
                    <div>
                        <a href="javascript:editData(`'.$subject->id.'`, `'.$subject->name.'`)" class="btn btn-outline-warning btn-xs rounded"><i class="fa fa-edit"></i></a>
                        <a href="javascript:deleteData(`'.$subject->id.'`, `'.$subject->name.'`)" class="btn btn-outline-danger btn-xs rounded"><i class="fa fa-trash-o"></i></a>
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store($type, Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => $validator->errors()->first()
            ]);
        }

        $isExists = Subject::where('name', $request->name)->where('type', strtoupper($type))->exists();
        if ($isExists) {
            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => 'Mata Pelajaran Rapor sudah ada.',
            ]);
        }

        Subject::create([
            'name' => $request->name,
            'type' => strtoupper($type)
        ]);

        return response()->json([
            'STATUS' => 'SUCCESS',
            'MESSAGE' => 'Berhasil menambahkan mata pelajaran'
        ]);
    }

    public function update($type, Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => $validator->errors()->first()
            ]);
        }

        $subject = Subject::where('type', strtoupper($type))->findOrFail($request->id);

        $isExists = Subject::where('name', $request->name)
            ->where('id', '!=', $request->id)
            ->where('type', strtoupper($type))
            ->exists();
        if ($isExists) {
            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => 'Mata Pelajaran Rapor sudah ada.',
            ]);
        }

        $subject->update([
            'name' => $request->name
        ]);

        return response()->json([
            'STATUS' => 'SUCCESS',
            'MESSAGE' => 'Berhasil mengupdate mata pelajaran'
        ]);
    }

    public function destroy($type, Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $subject = Subject::where('type', strtoupper($type))->findOrFail($request->id);
        $subject->delete();

        return response()->json([
            'STATUS' => 'SUCCESS',
            'MESSAGE' => 'Berhasil menghapus mata pelajaran'
        ]);
    }
}
