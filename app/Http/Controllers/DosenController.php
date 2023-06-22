<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function index_dosen()
{
return view('indexdosen');
}
    public function dosen_read()
        {
            $model=new Dosen();
            $datas=$model->all();
            foreach($datas as $dt){
                $data[]=[
                    'nidn'=>$dt->nidn,
                    'nama'=>$dt->nama,
                    'alamat'=>$dt->alamat,
                    'jurusan'=>$dt->jurusan
                ];
            }

            if (!empty($data)){
                $success = true;
                $massage = "Data berhasil dibaca";
            }else{
                $success = false;
                $massage = "Data tidak ditemukan/kosong";
            }
            $balikan = [
                "success"=>$success,
                "massage"=>$massage,
                "data"=> @$data
            ];

            return response()->json($balikan);
        }

        public function dosen_create(Request $req)
        {
            $model=new Dosen();
            $model->nidn=$req->nidn;
            $model->nama=$req->nama;
            $model->alamat=$req->alamat;
            $model->jurusan=$req->jurusan;
            if($model->save()){
                $success=true;
                $massage="Data berhasil disimpan";
            }else{
                $success=false;
                $massage="Data gagal disimpan";
            }

            $balikan = [
                "success"=>$success,
                "massage"=>$massage,
                "data"=> @$req->all()
            ];

            return response()->json($balikan);
        }

        public function dosen_update(Request $request)
        {
            $nidn = $request->nidn;
            //echo "$nidn"; exit;
            $dosen = Dosen::find($nidn);
            if (!$dosen) {
                return response()->json(['message' => 'dosen not found'], 404);
            }

            $request->validate([
                'nama' => 'required',
                'alamat' => 'required',
                'jurusan' => 'required',
            ]);

            $dosen->update($request->all());

            return response()->json(['message' => 'Dosen updated successfully', 'dosen' => $dosen]);
        }

        public function dosen_destroy($nidn)
        {
            $dosen = Dosen::find($nidn);
            if (!$dosen) {
                return response()->json(['message' => 'Dosen not found'], 404);
            }
    
            $dosen->delete();
    
            return response()->json(['message' => 'Dosen deleted successfully']);
        }

}