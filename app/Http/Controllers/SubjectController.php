<?php

namespace App\Http\Controllers;

use DataTables;
use App\Subject;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index($type)
    {
        $latestSubject = Subject::where('type', strtoupper($type))->latest('order_no')->first();
        $nextOrderNo = isset($latestSubject) ? ($latestSubject->order_no + 1) : 1;

        return view('subjects.index', compact('nextOrderNo'));
    }

    public function datatables($type, Request $request)
    {
        $subjects = Subject::query()->where('type', strtoupper($type))->get();

        return DataTables::of($subjects)
            ->addColumn('action', function ($subject) {
                $action = '
                    <div>
                        <a href="javascript:editData(`'.$subject->id.'`, `'.$subject->name.'`, `'.$subject->order_no.'`)" class="btn btn-outline-warning btn-xs rounded"><i class="fa fa-edit"></i></a>
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
            'name' => 'required',
            'order_no' => 'required|numeric'
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
                'MESSAGE' => 'Mata Pelajaran '.ucwords(strtolower($type)).' sudah ada.',
            ]);
        }

        $mustSortSbj = Subject::select('id', 'order_no')
            ->where('type', strtoupper($type))
            ->where('order_no', '>=', $request->order_no)
            ->orderBy('order_no', 'asc')
            ->get();

        DB::beginTransaction();

        try {
            foreach ($mustSortSbj as $sbj) {
                $sbj->update([
                    'order_no' => $sbj->order_no + 1
                ]);
            }
            
            Subject::create([
                'name' => $request->name,
                'type' => strtoupper($type),
                'order_no' => $request->order_no
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => 'Terjadi kesalahan internal'
            ]);
        }

        return response()->json([
            'STATUS' => 'SUCCESS',
            'MESSAGE' => 'Berhasil menambahkan mata pelajaran'
        ]);
    }

    public function update($type, Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'order_no' => 'required'
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
            ->first();
        if ($isExists) {
            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => 'Mata Pelajaran '.ucwords(strtolower($type)).' sudah ada.',
            ]);
        }

        $mustSortSbj = [];
        $addition = 1;
        if ($request->order_no != $subject->order_no) {
            if ($request->order_no > $subject->order_no) {
                $mustSortSbj = Subject::select('id', 'order_no')
                    ->where('type', strtoupper($type))
                    ->where('order_no', '>', $subject->order_no)
                    ->where('order_no', '<=', $request->order_no)
                    ->get();

                    $addition = -1;
            } else {
                $mustSortSbj = Subject::select('id', 'order_no')
                    ->where('type', strtoupper($type))
                    ->where('order_no', '>=', $request->order_no)
                    ->where('order_no', '<', $subject->order_no)
                    ->get();
            }
        }

        DB::beginTransaction();

        try {
            foreach ($mustSortSbj as $sbj) {
                $sbj->update([
                    'order_no' => $sbj->order_no + $addition
                ]);
            }
            
            $subject->update([
                'name' => $request->name,
                'order_no' => $request->order_no
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => 'Terjadi kesalahan internal'
            ]);
        }

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
        $mustSortSbj = Subject::select('id', 'order_no')
            ->where('type', strtoupper($type))
            ->where('order_no', '>=', $subject->order_no)
            ->orderBy('order_no', 'asc')
            ->get();

        DB::beginTransaction();

        try {
            foreach ($mustSortSbj as $sbj) {
                $sbj->update([
                    'order_no' => ($sbj->order_no - 1)
                ]);
            }
            
            $subject->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => 'Terjadi kesalahan internal'
            ]);
        }

        return response()->json([
            'STATUS' => 'SUCCESS',
            'MESSAGE' => 'Berhasil menghapus mata pelajaran'
        ]);
    }
}
