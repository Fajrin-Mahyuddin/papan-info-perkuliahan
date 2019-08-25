<?php

namespace App\Http\Controllers;

use App\Model\JadwalKuliah;
use App\Model\PindahJadwal;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    public function index()
    {
        return view('screen.index');
    }

    public function ajaxJadwal()
    {
        $data  = JadwalKuliah::with(['data_kelas', 'data_mk', 'data_dosen'])->get();
        return response()->json($data);
    }

    public function ajaxPindah()
    {
        $data  = PindahJadwal::with(['data_kelas', 'data_jadwal'])->get();
        return response()->json($data);
    }

    

}
