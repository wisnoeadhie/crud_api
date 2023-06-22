<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index_mahasiswa()
{
return view('index');
}

    public function mahasiswa_read()
    {
        $model=new Mahasiswa();
        $datax=$model->all();
        foreach($datax as $dt){
            $data[]=[
                'nim'=>$dt->nim,
                'nama'=>$dt->nama,
                'umur'=>$dt->umur,
                'alamat'=>$dt->alamat,
                'kota'=>$dt->kota,
                'kelas'=>$dt->kelas,
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

    public function mahasiswa_create(Request $req)
    {
        $model=new Mahasiswa();
        $model->nim=$req->nim;
        $model->nama=$req->nama;
        $model->umur=$req->umur;
        $model->alamat=$req->alamat;
        $model->kota=$req->kota;
        $model->kelas=$req->kelas;
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

    public function mahasiswa_update(Request $request)
    {
        $nim = $request->nim;
        //echo "$nim"; exit;
        $mahasiswa = Mahasiswa::find($nim);
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }

        $request->validate([
            'nama' => 'required',
            'umur' => 'required|integer',
            'alamat' => 'required',
            'kota' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ]);

        $mahasiswa->update($request->all());

        return response()->json(['message' => 'Mahasiswa updated successfully', 'mahasiswa' => $mahasiswa]);
    }

    public function mahasiswa_destroy($nim)
        {
            $mahasiswa = Mahasiswa::find($nim);
            if (!$mahasiswa) {
                return response()->json(['message' => 'Mahasiswa not found'], 404);
            }
    
            $mahasiswa->delete();
    
            return response()->json(['message' => 'Mahasiswa deleted successfully']);
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('token-name');
            return response()->json(['access_token' => $token->plainTextToken,]);
        }
        return response()->json(['message' => 'Invalid login credentials',], 401);
    }
}