<?php

namespace App\Http\Controllers;

use AdminHelper;
use Carbon\Carbon;
use App\Model\Kelas;
use App\Model\Informasi;
use App\Model\JadwalKuliah;
use App\Model\PindahJadwal;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('ket', 'aktif')->get();
        $info = Informasi::where('id_semester', AdminHelper::getSemester()->id_semester)->get();
       
        return view('screen.index')->with(['kelass' => $kelas, 'informasi' => $info]);
    }

    public function ajaxJadwal()
    {
        $hari = Carbon::parse(now())->isoFormat('dddd');
        $data  = JadwalKuliah::with(['data_kelas', 'data_mk', 'data_dosen', 'data_pindah'])->where('hari', $hari)->get();
        return response()->json($data);
    }

    public function ajaxPindah()
    {
        $data  = PindahJadwal::with(['data_kelas', 'data_jadwal', 'data_jadwal.data_kelas', 'data_jadwal.data_mk', 'data_jadwal.data_dosen'])->get();
        return response()->json($data);
    }
    

}
