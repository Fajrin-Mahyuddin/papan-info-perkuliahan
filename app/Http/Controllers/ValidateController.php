<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use AdminHelper;
use Carbon\Carbon;
use App\Model\Kelas;
use App\Model\Absen;
use App\Model\JadwalKuliah;
use App\Model\UserValidasi;
use App\Events\JadwalEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ValidateController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('status', 'aktif')->get();
        return view('mhs.main')->with('kelas', $kelas);
    }

    public function daftar()
    {
        return view('administrator.absensi.index');
    }

    public function daftarDosen()
    {
        $total = DB::table('tbd_absen')->join('tbm_mata_kuliah', 'tbd_absen.id_mk', '=', 'tbm_mata_kuliah.id_mk')->select('tbd_absen.*', 'tbm_mata_kuliah.*')->where('tbd_absen.id_dosen', Auth::user()->data_dosen->id_dosen)->sum('tbm_mata_kuliah.sks');

        return view('dosen.absensi.index')->with('total', $total);
    }

    public function postLogin(Request $request)
    {

        $kelas      = $request->kelas;
        $password   = $request->password;
        $ruangan   = $request->ruangan;
        if(empty($kelas) OR empty($password) OR empty($ruangan)) {
            return response()->json(['errors' => 'Form Masih Kosong !']);
        }

        $check = UserValidasi::where('nama', $kelas)->first();
        $data = JadwalKuliah::with(['data_pindah.data_kelas', 'data_kelas', 'data_mk', 'data_dosen'])->where('status', '!=', '-')->get();
        $ruangan = Kelas::where('id_kelas', $ruangan)->first();

        if($check) {
            if(Hash::check($password, $check->pass)) {
                return response()->json(['data' => $data, 'ruangan' => $ruangan]);
            } else {
                return response()->json(['errors' => 'Username dan Password Salah !']);
            }
        } else {
            return response()->json(['errors' => 'Gagal !']);
        }
    }

    public function konfirmasi(Request $request, $id)
    {
        $id_jadwal = $id;
        $jadwal = JadwalKuliah::with('data_pindah')->where('id_jadwal', $id_jadwal)->first();

        $kelas  = $jadwal->id_kelas;
        $jam    = $jadwal->jam_mulai;
        $ket    = '-';
        $tgl    = date('Y-m-d');

        if($jadwal->status === 'pindah') {
            $kelas  = $jadwal->data_pindah->id_kelas;
            $jam    = $jadwal->data_pindah->jam_mulai_pindah;
            $tgl    = $jadwal->data_pindah->tgl_pindah;
            $ket    = 'pindah';
        }

        if(!empty(AdminHelper::getSemester()->id_semester)) {
            $id_semester = AdminHelper::getSemester()->id_semester; 
        } else {
            return response()->json(['errors' => 'Tahun ajaran masih kosong !']);        
        }        

        $cek = Absen::where('id_dosen', $jadwal->id_dosen)->where('id_kelas', $kelas)->where('id_mk', $jadwal->id_mk)->where('jam', $jam)->where('tanggal', $tgl)->where('ket', $ket)->exists();
        if($cek === true) {
            return redirect('mhs');
        }

        $absen = Absen::create([ 
            'id_dosen'  => $jadwal->id_dosen,
            'id_jadwal' => $jadwal->id_jadwal,
            'id_kelas'  => $kelas,
            'id_mk'     => $jadwal->id_mk,
            'jam'       => $jam,
            'tanggal'   => $tgl,
            'ket'       => $ket,
            'id_semester'   => $id_semester,
        ]);

        return redirect('mhs');
        
    }

    public function cekData(Request $request)
    {
        $check = Absen::where('id_jadwal', $request->id)->exists();
        if($check) {
            return response()->json([true]);
        }
    }

    public function ajaxData()
    {
        $data = Absen::with(['data_dosen', 'data_kelas', 'data_mk'])->orderBy('tanggal', 'asc')->get();

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('durasi', function($data) {
                                return $data->data_mk->sks. ' Jam';
                            })->addColumn('tanggal', function($data) {
                                $tgl = Carbon::parse($data->tanggal)->isoFormat('dddd, DD MMMM YYYY');
                                return $tgl . ' - <span class="badge badge-primary"><span class="fa fa-check"></span></span>'; 
                            })->escapeColumns([])->make(true);
    }

    public function ajaxDosen()
    {
        $data = Absen::with(['data_dosen', 'data_kelas', 'data_mk'])->orderBy('tanggal', 'asc')->where('id_dosen', Auth::user()->data_dosen->id_dosen)->where('tanggal', date('Y-m-d'))->get();

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('durasi', function($data) {
                                return $data->data_mk->sks. ' Jam';
                            })->addColumn('tanggal', function($data) {
                                $tgl = Carbon::parse($data->tanggal)->isoFormat('dddd, DD MMMM YYYY');
                                return $tgl . ' - <span class="badge badge-primary"><span class="fa fa-check"></span></span>'; 
                            })->escapeColumns([])->make(true);
    }

}
