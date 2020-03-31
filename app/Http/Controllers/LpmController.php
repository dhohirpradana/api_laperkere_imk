<?php

namespace App\Http\Controllers;

use App\Lpm;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class lpmController extends Controller
{
    //
    public function index()
    {
        $lpm = Lpm::all();

        $data = ['lpm' => $lpm];

        return $data;
    }

    public function create(Request $request)
    {

        //Done
        $lpm = new Lpm();
        $lpm->user_id = $request->input('user_id');
        $lpm->pesan = $request->input('pesan');

        $lpm->is_deleted = '0';

        $foto = $request->file('foto');
        $extension = $foto->getClientOriginalExtension();
        Storage::disk('public')->put($foto->getFilename() . '.' . $extension, File::get($foto));

        $lpm->foto = $foto->getFilename().'.'.$extension;

        // if ($request->hasFile('myimage')) {
        //     if ($request->file('myimage')->isValid()) {
        //         $lpm = Lpm::user();
        //         $image_name = date('mdYHis') . uniqid() . $request->file('myimage')->getClientOriginalName();
        //         $path = base_path() . '/public/img';
        //         $request->file('myimage')->move($path, $image_name);
        //         $lpm->foto = $path . $image_name;
        //         $lpm->save();
        //         return redirect()->back();
        //     }
        //     return redirect()->back()->with('error', 'image not valid');
        // }
        // return redirect()->back()->with('error', 'no image');

        try {
            //code...
            $lpm->save();
            return response()->json(['msg' => 'Berhasil Membuat Data : ' . $lpm->id, 'value' => 1]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['msg' => 'Gagal Membuat', 'value' => 0]);
        }
    }

    public function update(Request $request, $id)
    {
        $lpm = Lpm::find($id);
        // $lpm->pesan = $request->input('pesan');
        $lpm->pesan = $request->pesan;
        try {
            $lpm->save();
            //code...
            return response()->json(['msg' => 'Berhasil Update Data Id : ' . $id, 'value' => 1]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['msg' => 'Gagal Update', 'value' => 0]);
        }
    }

    public function uploadFoto(Request $request)
    {
        if ($request->hasFile('foto')) {
            // Do a loop over all images
            foreach ($request->file('foto') as $image) {
                if ($image->isValid()) {
                    $lpm = Lpm::lpm();
                    $image_name = date('mdYHis') . uniqid() . $image->getClientOriginalName();
                    $path = base_path() . '/public';
                    $image->move($path, $image_name);
                    $lpm->foto = $path . $image_name;
                    $lpm->save();
                    return redirect()->back();
                }
            }
            // end loop
        }
        return redirect()->back()->with('error', 'no image');
    }

    public function delete($id)
    {
        $lpm = Lpm::find($id);
        // $lpm->delete();
        if (!is_null($lpm)) {
            return response()->json(['msg' => 'Berhasil Hapus Data Id : ' . $id, 'value' => 1]);
        } else {
            return response()->json(['msg' => 'Gagal Hapus', 'value' => 0]);
        }
    }

    public function detail($id)
    {
        $lpm = Lpm::find($id);

        if (!is_null($lpm)) {
            return response()->json([
                'msg' => 'Data Ada', 'value' => 1,
                'lpm_id' => $lpm['id'],
                'pesan' => $lpm['pesan'],
                // 'tahun' => substr($lpm['updated_at'], 0, 4),
                // 'bulan' => substr($lpm['updated_at'], 5, 2),
                // 'tanggal' => substr($lpm['updated_at'], 8, 2),
                // 'test_tgl' => $lpm['updated_at'],
                'created_at' => substr($lpm['updated_at'], 11, 5) . ', ' . substr($lpm['updated_at'], 8, 2) . '-' . substr($lpm['updated_at'], 5, 2) . '-' . substr($lpm['updated_at'], 0, 4),
            ]);
        } else {
            return response()->json(['msg' => 'Data Tidak Ada', 'value' => 0]);
        }
    }
}
