<?php

namespace App\Http\Controllers;

use App\Auth;
use App\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    //
    public function index()
    {
        $user = User::all();

        $data = ['user' => $user];

        return $data;
    }

    public function create(Request $request)
    {
        $user = new User();
        $user->user_id = $request->input('user_id');
        $user->pesan = $request->input('pesan');
        $user->is_deleted = '0';
        try {
            //code...
            $user->save();
            return response()->json(['msg' => 'Berhasil Membuat Data Oleh User Id : ' . $user->user_id, 'value' => 1]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['msg' => 'Gagal Membuat', 'value' => 0]);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        // $lpm->pesan = $request->input('pesan');
        $user->pesan = $request->pesan;
        try {
            $user->save();
            //code...
            return response()->json(['msg' => 'Berhasil Update Data Id : ' . $id, 'value' => 1]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['msg' => 'Gagal Update', 'value' => 0]);
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        // $auth->delete();
        if (!is_null($user)) {
            return response()->json(['msg' => 'Berhasil Hapus Data Id : ' . $id, 'value' => 1]);
        } else {
            return response()->json(['msg' => 'Gagal Hapus', 'value' => 0]);
        }
    }

    public function detail($id)
    {
        $user = User::find($id);

        if (!is_null($user)) {
            return response()->json([
                'msg' => 'Data Ada', 'value' => 1,
                'lpm_id' => $user['id'],
                'pesan' => $user['pesan'],
                // 'tahun' => substr($lpm['updated_at'], 0, 4),
                // 'bulan' => substr($lpm['updated_at'], 5, 2),
                // 'tanggal' => substr($lpm['updated_at'], 8, 2),
                // 'test_tgl' => $lpm['updated_at'],
                'created_at' => substr($user['updated_at'], 11, 5) . ', ' . substr($user['updated_at'], 8, 2) . '-' . substr($user['updated_at'], 5, 2) . '-' . substr($user['updated_at'], 0, 4),
            ]);
        } else {
            return response()->json(['msg' => 'Data Tidak Ada', 'value' => 0]);
        }
    }
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
