<?php

namespace App\Http\Controllers;

use App\Curriculum;
use DB;
use Illuminate\Http\Request;
use Session;

class CurriculumController extends Controller
{
    public function index() {
        $curriculums = Curriculum::with(['curriculumScoreCols' => function ($q) {
            $q->orderBy('order_no', 'asc');
        }])
        ->orderBy('created_at', 'desc')
        ->paginate();

        return view('curriculums.index', compact('curriculums'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);

        $cur = Curriculum::create([ 'name' => $request->name ]);
        $cur->curriculumScoreCols()->create([
            'name' => 'Nilai Mapel',
            'order_no' => 1
        ]);

        Session::put('SUCCESS', 'Curriculum saved successfully.');
        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
        ]);

        $cur = Curriculum::findOrFail($id);
        $cur->update([ 'name' => $request->name ]);

        Session::put('SUCCESS', 'Curriculum saved successfully.');
        return redirect()->back();
    }

    public function destroy($id) {
        $cur = Curriculum::findOrFail($id);

        $exists = $cur->periods()->exists();
        if ($exists) {
            Session::put('ERROR', 'Kurikulum tidak bisa dihapus karena sudah digunakan pada salah satu periode');
            return redirect()->back();
        }

        $cur->delete();

        Session::put('SUCCESS', 'Curriculum saved successfully.');
        return redirect()->back(); 
    }

    public function storeCol(Request $request, $curId) {
        $request->validate([
            'name' => 'required',
            'order_no' => 'required|numeric',
        ]);

        $cur = Curriculum::findOrFail($curId);

        $mustSortCols = $cur->curriculumScoreCols()
            ->where('order_no', '>=', $request->order_no)
            ->get();

        DB::beginTransaction();
        try {
            foreach($mustSortCols as $mustSort) {
                $mustSort->update([
                    'order_no' => ++$mustSort->order_no
                ]);
            }

            $cur->curriculumScoreCols()->create([
                'name' => $request->name,
                'order_no' => $request->order_no
            ]);
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            Session::put('ERROR', 'Terjadi kesalahan internal');
            return redirect()->back();
        }

        Session::put('SUCCESS', 'Berhasil menyimpan parameter nilai');
        return redirect()->back();
    }

    public function updateCol(Request $request, $curId, $colId) {
        $request->validate([
            'name' => 'required',
            'order_no' => 'required|numeric',
        ]);

        $cur = Curriculum::findOrFail($curId);
        $col = $cur->curriculumScoreCols()->findOrFail($colId);

        $mustSortCols = [];
        $addition = 1;
        if ($request->order_no != $col->order_no) {
            if ($request->order_no > $col->order_no) {
                $mustSortCols = $cur->curriculumScoreCols()
                    ->where('order_no', '>', $col->order_no)
                    ->where('order_no', '<=', $request->order_no)
                    ->get();

                    $addition = -1;
            } else {
                $mustSortCols = $cur->curriculumScoreCols()
                    ->where('order_no', '>=', $request->order_no)
                    ->where('order_no', '<', $col->order_no)
                    ->get();
            }
        }

        DB::beginTransaction();
        try {
            foreach ($mustSortCols as $mustSort)  {
                $mustSort->update([ 
                    'order_no' => $mustSort->order_no + $addition 
                ]);
            }

            $col->update([
                'name'  => $request->name,
                'order_no' => $request->order_no
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            Session::put('ERROR', 'Terjadi kesalahan internal');
            return redirect()->back();
        }

        Session::put('SUCCESS', 'Berhasil update parameter nilai');
        return redirect()->back();
    }

    public function destroyCol($curId, $colId) {
        $cur = Curriculum::findOrFail($curId);
        $col = $cur->curriculumScoreCols()->findOrFail($colId);

        if (count($cur->curriculumScoreCols) == 1) {
            Session::put('ERROR', 'Kurikulum harus terdapat minimal 1 parameter nilai');
            return redirect()->back();
        }

        $mustSortCol = $cur->curriculumScoreCols()
            ->where('order_no', '>', $col->order_no)
            ->get();

        DB::beginTransaction();
        try {
            foreach ($mustSortCol as $mustSort) {
                $mustSort->update([
                    'order_no' => --$mustSort->order_no
                ]);
            } 

            $col->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            Session::put('ERROR', 'Terjadi kesalahan internal');
            return redirect()->back();
        }

        Session::put('SUCCESS', 'Berhasil menghapus parameter nilai');
        return redirect()->back();
    }
}
