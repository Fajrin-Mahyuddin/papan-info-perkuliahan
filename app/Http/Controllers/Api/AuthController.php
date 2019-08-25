<?php

namespace App\Http\Controllers\Api;

use Auth;
use Validator;
use App\Model\JadwalKuliah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index()
    {
        $data = JadwalKuliah::with(['data_kelas', 'data_mk', 'data_dosen'])->where('id_dosen', Auth::user()->data_dosen->id_dosen)->get();
        return response()->json($data);
    }

    public function postlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }
        dd($_REQUEST['header']);
        $log = Auth::attempt(['username' => $request->username, 'password' => $request->password]);
        
        if(!$log) {
            return 'Berhasil Login';
        }

        return 'Gagal Login';

    }

}
