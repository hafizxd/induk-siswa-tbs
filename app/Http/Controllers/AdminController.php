<?php

namespace App\Http\Controllers;

use App\User;
use DataTables;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view('admins.index');
    }

    public function datatables(Request $request)
    {
        $admins = User::query();

        return DataTables::of($admins)
            ->addIndexColumn()
            ->editColumn('name', function ($admin) {
                $name = $admin->name;

                if ($admin->id == auth()->user()->id) {
                    $name .= ' <span class="badge badge-primary">Saya</span>';
                }

                return $name;
            })
            ->addColumn('action', function ($admin) {
                $action = '<div>';

                if ($admin->id == auth()->user()->id) {
                    $action .= '<a href="javascript:editDataMe(`'.$admin->id.'`, `'.$admin->name.'`, `'.$admin->username.'`)" class="btn btn-outline-warning btn-xs rounded"><i class="fa fa-edit"></i></a>';
                } else {
                    $action .= '<a href="javascript:editData(`'.$admin->id.'`, `'.$admin->name.'`)" class="btn btn-outline-warning btn-xs rounded"><i class="fa fa-edit"></i></a> ';
                    $action .= '<a href="javascript:deleteData(`'.$admin->id.'`, `'.$admin->name.'`)" class="btn btn-outline-danger btn-xs rounded"><i class="fa fa-trash-o"></i></a>';
                }

                $action .= '</div>';

                return $action;
            })
            ->rawColumns(['name', 'action'])
            ->make();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'username' => 'required|unique:users|regex:/^[a-z]+$/',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => $validator->errors()->first()
            ]);
        }

        $isExists = User::where('name', $request->name)->exists();
        if ($isExists) {
            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => 'Admin sudah ada.',
            ]);
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'STATUS' => 'SUCCESS',
            'MESSAGE' => 'Berhasil menambahkan admin'
        ]);
    }

    public function update(Request $request)
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

        $admin = User::findOrFail($request->id);

        $admin->update([
            'name' => $request->name
        ]);

        return response()->json([
            'STATUS' => 'SUCCESS',
            'MESSAGE' => 'Berhasil mengupdate admin'
        ]);
    }

    public function updateMe(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'username' => [
                'required',
                Rule::unique('users', 'username')->ignore(auth()->user()->id),
                'regex:/^[a-z]+$/'
            ],
            'password' => 'nullable',
            'confirm_password' => 'required_with:password|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'STATUS' => 'ERROR',
                'MESSAGE' => $validator->errors()->first()
            ]);
        }

        $updateData = [
            'name' => $request->name,
            'username' => $request->username
        ];

        if (isset($request->password)) {
            $updateData['password'] = Hash::make($request->password);
        }

        auth()->user()->update($updateData);

        return response()->json([
            'STATUS' => 'SUCCESS',
            'MESSAGE' => 'Berhasil mengupdate data diri'
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $admin = User::findOrFail($request->id);
        $admin->delete();

        return response()->json([
            'STATUS' => 'SUCCESS',
            'MESSAGE' => 'Berhasil menghapus admin'
        ]);
    }
}
