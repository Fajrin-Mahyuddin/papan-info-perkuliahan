<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use AdminHelper;
use Carbon\Carbon;
use App\Model\Kelas;
use App\Events\HapusEvent;
use App\Events\PindahEvent;
use App\Events\JadwalEvent;
use App\Model\JadwalKuliah;
use App\Model\PindahJadwal;
use Illuminate\Http\Request;

class DataDosenController extends Controller
{

    public function jadwalIndex()
    {

        return view('dosen.jadwal.index');
    }

    public function pindahIndex()
    {
        return view('dosen.pindah.index');
    }

    public function check_valid($id)
    {
        $id_decode  = base64_decode($id);
        $id_arr     = explode('-', $id_decode);
        
        $data       = JadwalKuliah::where('id_jadwal', $id_arr[1])->first();
        
        $val_2      = date('Y/m/d').'-'.$id_arr[1].'-';
        $val_encode = base64_encode($val_2);
        if($id !== $val_encode) {            
            return ['status' => false, 'data' => null];
        }
        return ['status' => true, 'data' => $data];
    }

    public function edit(Request $req, $id)
    {
        $isValid = $this->check_valid($id);
        if(!$isValid['status']) {
            return redirect('dosen/jadwal/daftar');
        }

        $kelas = Kelas::get()->except($isValid['data']->id_kelas);  
        
        return view('dosen.pindah.form_pindah')->with(['data' => $isValid['data'], 'kelas' => $kelas]);
    }

    public function update(Request $request)
    {

        $pindah     = PindahJadwal::updateOrCreate([
            'id_jadwal'         => $request->id_jadwal
        ],[
           'id_jadwal'          => $request->id_jadwal,
           'id_kelas'           => $request->id_kelas,
           'jam_mulai_pindah'   => $request->jam_mulai_pindah,
           'jam_akhir_pindah'   => $request->jam_akhir_pindah,
           'tgl_pindah'         => $request->tgl_pindah  
        ]);
        $pindah->data_jadwal->where('id_jadwal', $request->id_jadwal)->update(['status' => 'pindah']);
        // $hari = Carbon::parse(now())->isoFormat('dddd');
        // $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $pindah->id_jadwal)->where('hari', $hari)->first();
        // $pindah = PindahJadwal::with(['data_jadwal', 'data_jadwal.data_mk', 'data_jadwal.data_dosen', 'data_kelas'])->where('id_jadwal', $pindah->id_jadwal)->first();
        // if($jadwal) {
        //     event(new JadwalEvent($jadwal));
        // }
        // event(new PindahEvent($pindah));
        return redirect('dosen/pindah/jadwal/daftar')->with('status', 'Success !');
    }

    public function pindahToday()
    {
        // $data  = PindahJadwal::with('data_jadwal', 'data_jadwal.data_mk', 'data_jadwal.data_dosen', 'data_kelas')->where('id_dosen', Auth::user()->data_dosen->id_dosen)
        //                         ->where(function($query) {
        //                             $query->where('hari', AdminHelper::getToday())->where('status', 'pindah')->orWhere('status', 'masuk');
        //                         })->get();
        $data = DB::table('tbd_jadwal_kuliah')
                ->join('tbd_pindah_jadwal', 'tbd_jadwal_kuliah.id_jadwal', '=', 'tbd_pindah_jadwal.id_jadwal')
                ->join('tbd_dosen', 'tbd_jadwal_kuliah.id_dosen', '=', 'tbd_dosen.id_dosen')
                ->join('tbm_kelas', 'tbd_jadwal_kuliah.id_kelas', '=', 'tbm_kelas.id_kelas')
                ->join('tbm_mata_kuliah', 'tbd_jadwal_kuliah.id_mk', '=', 'tbm_mata_kuliah.id_mk')
                ->select('tbd_jadwal_kuliah.*','tbd_jadwal_kuliah.ket as ket_jadwal', 'tbd_jadwal_kuliah.status as status_jadwal', 'tbd_pindah_jadwal.*', 'tbd_pindah_jadwal.ket as ket_pindah', 'tbd_dosen.*', 'tbd_dosen.nama as nama_dosen', 'tbd_dosen.status as status_dosen', 'tbd_dosen.ket as ket_dosen', 'tbm_kelas.*', 'tbm_kelas.nama as nama_kelas', 'tbm_kelas.status as status_kelas', 'tbm_kelas.ket as ket_kelas', 'tbm_mata_kuliah.*', 'tbm_mata_kuliah.nama as nama_mata_kuliah', 'tbm_mata_kuliah.ket as ket_mata_kuliah')
                ->where(function($query){
                    $query->where('tbd_jadwal_kuliah.status', 'pindah')->orWhere('tbd_pindah_jadwal.ket', 'masuk');
                })->where('tbd_jadwal_kuliah.id_dosen', Auth::user()->data_dosen->id_dosen)
                ->whereDate('tbd_pindah_jadwal.tgl_pindah', now())
                ->get();
        // dd($data);
        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('aksi', function($data) {
                                        if(Auth::user()->data_dosen->status === 'aktif') {
                                            if($data->ket_pindah === 'masuk') {
                                                return '<a href="'.url('dosen/jadwal/daftar/selesai/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn btn-sm btn-danger" data-id="'.$data->id_jadwal.'"><i class="fa fa-check"></i> Selesai</a>';
                                            } else {
                                                return '<a href="'.url('dosen/jadwal/daftar/masuk/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn btn-sm btn-success" data-id="'.$data->id_jadwal.'"><i class="fa fa-sign-out"></i> Masuk</a>';
                                            }
                                        }                                        
                                    })->escapeColumns([])->make(true);
    }

    public function jadwalToday()
    {
        $data  = JadwalKuliah::with(['data_dosen', 'data_mk', 'data_kelas', 'data_semester'])->where('hari', AdminHelper::getToday())->where('status', '!=', 'pindah')->where('id_dosen', Auth::user()->data_dosen->id_dosen);
        
        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('hari', function($data) {
                                        return '<span class="upCaseFont">'.$data->hari.'</span>';
                                    })->addColumn('aksi', function($data) {
                                        if(Auth::user()->data_dosen->status === 'aktif') {
                                            if($data->status === 'masuk') {
                                                return '<a href="'.url('dosen/jadwal/daftar/keluar/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn btn-sm btn-danger" data-id="'.$data->id_jadwal.'"><i class="fa fa-sign-out"></i> Selesai</a>'; 
                                            } else {
                                                return '<a href="'.url('dosen/jadwal/daftar/masuk/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn btn-sm btn-success" data-id="'.$data->id_jadwal.'"><i class="fa fa-sign-out"></i> Masuk</a>'; 
                                            }
                                        }
                                    })->escapeColumns([])->make(true);
    }

    public function ajaxJadwal()
    {
        $data  = JadwalKuliah::with(['data_dosen', 'data_mk', 'data_kelas', 'data_semester'])->where('id_dosen', Auth::user()->data_dosen->id_dosen)->get();
        
        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('hari', function($data) {
                                        return '<span class="upCaseFont">'.$data->hari.'</span>';
                                    })->addColumn('aksi', function($data) {
                                        if($data->status == 'masuk') {
                                            return '';
                                        } else {
                                            return '<a href="'.url('dosen/pindah/jadwal/daftar/tambah/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn btn-sm btn-success" data-id="'.$data->id_jadwal.'"><i class="fa fa-sign-out"></i> Pindah</a>';
                                        }
                                    })->escapeColumns([])->make(true);
    }

    public function ajaxPindah()
    {
        $data  = JadwalKuliah::with('data_pindah', 'data_mk', 'data_dosen', 'data_pindah.data_kelas')->where('id_dosen', Auth::user()->data_dosen->id_dosen)->where('status', 'pindah')->get();
   

        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('tgl_pindah', function($data) {
                                        return Carbon::parse($data->data_pindah->tgl_pindah)->isoFormat('dddd, DD MMMM YYYY');
                                    })->addColumn('aksi', function($data) {
                                        if($data->data_pindah->ket != 'masuk') {
                                            return '<a href="#" data-id="'.$data->id_pindah.'" data-id_jadwal="'.$data->id_jadwal.'" data-nama="'.$data->data_mk->nama.'" class="btn-delete-action"><i class="fa fa-trash"></i></a>';
                                        }
                                    })->escapeColumns([])->make(true);
    }

    public function generateMasuk($id)
    {
        $isValid = $this->check_valid($id);
        if(!$isValid['status']) {
            return redirect('dosen/jadwal/daftar');
        }

        if($isValid['data']->status == 'pindah') {
            // dd($isValid['data']->id_jadwal);
            $kelas  = Kelas::where('id_kelas', $isValid['data']->data_pindah->id_kelas)->update(['status' => 'aktif']);
            $pindah = PindahJadwal::where('id_jadwal', $isValid['data']->id_jadwal)->update(['ket' => 'masuk']);
            $pindah = PindahJadwal::with(['data_jadwal', 'data_jadwal.data_mk', 'data_jadwal.data_dosen', 'data_kelas'])->where('id_jadwal', $isValid['data']->id_jadwal)->first();
            // event(new PindahEvent($pindah));
        } else {
            JadwalKuliah::where('id_jadwal', $isValid['data']->id_jadwal)->update(['status' => 'masuk']);
            Kelas::where('id_kelas', $isValid['data']->id_kelas)->update(['status' => 'aktif']);
            // JadwalKuliah::where('id_dosen', Auth::user()->data_dosen->id_dosen)->where('status', 'masuk')->update(['status' => '-']);
            $hari = Carbon::parse(now())->isoFormat('dddd');
            $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $isValid['data']->id_jadwal)->where('hari', $hari)->first();
            // event(new JadwalEvent($jadwal));
        }
        return redirect('dosen');

    }

    public function generateKeluar($id)
    {
        $isValid = $this->check_valid($id);
        if(!$isValid['status']) {
            return redirect('dosen/jadwal/daftar');
        }

        if($isValid['data']->status == 'pindah') {
            // dd($isValid['data']->id_jadwal);
            $jadwal = JadwalKuliah::where('id_jadwal', $isValid['data']->id_jadwal)->update(['status' => '-']);
            $pindah = PindahJadwal::where('id_jadwal', $isValid['data']->id_jadwal)->delete();
            $pindah = PindahJadwal::with(['data_jadwal', 'data_jadwal.data_mk', 'data_jadwal.data_dosen', 'data_kelas'])->where('id_jadwal', $isValid['data']->id_jadwal)->first();
            // event(new PindahEvent($pindah));
        } else {
            JadwalKuliah::where('id_jadwal', $isValid['data']->id_jadwal)->update(['status' => '-']);
            // JadwalKuliah::where('id_dosen', Auth::user()->data_dosen->id_dosen)->where('status', 'masuk')->update(['status' => '-']);
            $hari = Carbon::parse(now())->isoFormat('dddd');
            $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $isValid['data']->id_jadwal)->where('hari', $hari)->first();
            // event(new JadwalEvent($jadwal));
        }
        return redirect('dosen');

    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $update = JadwalKuliah::where('id_jadwal', $request->id_jadwal)->update(['status' => '-']);
        $hari = \Carbon\Carbon::parse(now())->isoFormat('dddd');
        $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $request->id_jadwal)->where('hari', $hari)->first();
        if($jadwal) {
            event(new JadwalEvent($jadwal));
        }
        event(new HapusEvent($id));
        $delete = PindahJadwal::destroy($request->id);

        return response()->json(['data' => 'data']);
    }

}
