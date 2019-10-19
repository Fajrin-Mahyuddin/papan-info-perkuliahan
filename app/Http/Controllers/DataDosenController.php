<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Validator;
use DataTables;
use AdminHelper;
use Carbon\Carbon;
use App\Model\Kelas;
use App\Model\Dosen;
use App\Events\HapusEvent;
use App\Events\StatusEvent;
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

        $kelas = Kelas::where('ket', 'aktif')->get()->except($isValid['data']->id_kelas);  
        
        return view('dosen.pindah.form_pindah')->with(['data' => $isValid['data'], 'kelas' => $kelas]);
    }

    public function update(Request $request)
    {
        $msg = [
            'after_or_equal' => 'Tanggal pemindahan sudah lewat !',
            'before' => 'Format (24), waktu jam masuk harus setelah jam keluar !',
        ];
        $validator = Validator::make($request->all(), [
            'tgl_pindah'         => 'required|after_or_equal:today',
            'jam_mulai_pindah'   => 'required|before:jam_akhir_pindah',
            'jam_akhir_pindah'   => 'required'
        ], $msg);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $jadwal = JadwalKuliah::where('hari', AdminHelper::getToday($request->tgl_pindah))->where('id_jadwal', '!=', $request->id_jadwal)->where('id_kelas', $request->id_kelas)->get();
        $pindah = PindahJadwal::where('tgl_pindah', $request->tgl_pindah)->where('id_jadwal', '!=', $request->id_jadwal)->where('id_kelas', $request->id_kelas)->get();
        $validasi = AdminHelper::validateJadwal($jadwal, $request->jam_mulai_pindah, $request->jam_akhir_pindah);
        $validasi_pindah = AdminHelper::validateJadwal($pindah, $request->jam_mulai_pindah, $request->jam_akhir_pindah);
        if(!$validasi OR !$validasi_pindah) {
            return redirect()->back()->with('error', 'Kelas terpakai pada jam yang di pilih !');
        }

        $pindah     = PindahJadwal::updateOrCreate([
            'kode_pindah'       => $request->kode_pindah
        ],[
           'id_jadwal'          => $request->id_jadwal,
           'kode_pindah'        => $request->kode_pindah,
           'id_kelas'           => $request->id_kelas,
           'jam_mulai_pindah'   => $request->jam_mulai_pindah,
           'jam_akhir_pindah'   => $request->jam_akhir_pindah,
           'tgl_pindah'         => $request->tgl_pindah  
        ]);

        $pindah->data_jadwal->where('id_jadwal', $request->id_jadwal)->update(['status' => 'pindah']);
        $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $request->id_jadwal)->where('hari', AdminHelper::getToday())->first();
        $pindah = PindahJadwal::with(['data_jadwal', 'data_jadwal.data_mk', 'data_jadwal.data_kelas', 'data_jadwal.data_dosen', 'data_kelas'])->where('kode_pindah', $pindah->kode_pindah)->first();
        
        if($jadwal) {
            // kalau bukan jadwal hari ini maka buat event 
            event(new JadwalEvent($jadwal));
        }
        event(new PindahEvent($pindah));
       
        return redirect('dosen/pindah/jadwal/daftar')->with('status', 'Success !');
    }

    public function pindahToday()
    {
        $jadwal = JadwalKuliah::with('data_pindah')->where('status', 'pindah')->where('id_dosen', Auth::user()->data_dosen->id_dosen)->get();
        $arr_jadwal = [];
        foreach($jadwal as $val) {
            $value = array_push($arr_jadwal, $val->id_jadwal);
        }
        
        $data  = PindahJadwal::with('data_jadwal', 'data_jadwal.data_mk', 'data_jadwal.data_dosen', 'data_kelas')->whereIn('id_jadwal', $arr_jadwal)
                                ->where(function($query) {
                                    $query->whereDate('tgl_pindah', date('Y-m-d'));
                                })->get();
        
        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('aksi', function($data) {
                                        if(Auth::user()->data_dosen->status === 'aktif') {
                                            if($data->ket === 'masuk') {
                                                return '<a href="'.url('dosen/jadwal/daftar/keluar/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn btn-sm btn-danger" data-id="'.$data->id_jadwal.'"><i class="fa fa-check"></i> Selesai</a>';
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
                                            } elseif($data->status === '-') {
                                                return '<a href="'.url('dosen/jadwal/daftar/masuk/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn btn-sm btn-success" data-id="'.$data->id_jadwal.'"><i class="fa fa-sign-out"></i> Masuk</a>'; 
                                            } elseif($data->status === 'invalid') {
                                                // return '<a href="'.url('dosen/jadwal/daftar/keluar/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn btn-sm btn-warning" data-id="'.$data->id_jadwal.'"><i class="fa fa-sign-out"></i> Batal</a>'; 
                                                return ' ';
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
                                            return '<a href="#" data-id="'.$data->data_pindah->id_pindah.'" data-kode_pindah="'.$data->data_pindah->kode_pindah.'" data-id_jadwal="'.$data->id_jadwal.'" data-nama="'.$data->data_mk->nama.'" class="btn-delete-action"><i class="fa fa-trash"></i></a>';
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
            Kelas::where('id_kelas', $isValid['data']->data_pindah->id_kelas)->update(['status' => 'aktif']);
            PindahJadwal::where('id_jadwal', $isValid['data']->id_jadwal)->update(['ket' => 'masuk']);
            $kelas  = Kelas::where('id_kelas', $isValid['data']->data_pindah->id_kelas)->first();
            $pindah = PindahJadwal::with(['data_jadwal', 'data_jadwal.data_mk', 'data_jadwal.data_kelas', 'data_jadwal.data_dosen', 'data_kelas'])->where('id_jadwal', $isValid['data']->id_jadwal)->first();
            event(new PindahEvent($pindah));
        } else {
            Kelas::where('id_kelas', $isValid['data']->id_kelas)->update(['status' => 'aktif']);
            JadwalKuliah::where('id_jadwal', $isValid['data']->id_jadwal)->update(['status' => 'masuk']);
            $kelas  = Kelas::where('id_kelas', $isValid['data']->id_kelas)->first();
        
            $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $isValid['data']->id_jadwal)->where('hari', AdminHelper::getToday())->first();
            if($jadwal) {
                event(new JadwalEvent($jadwal));
            }
        }
        $data = ['kelas' => $kelas, 'tipe' => 'kelas'];
        event(new StatusEvent($data));
        return redirect('dosen');

    }

    public function generateKeluar($id)
    {
        $isValid = $this->check_valid($id);
        if(!$isValid['status']) {
            return redirect('dosen/jadwal/daftar');
        }

        if($isValid['data']->status == 'pindah') {
            Kelas::where('id_kelas', $isValid['data']->data_pindah->id_kelas)->update(['status' => 'nonAktif']);
            JadwalKuliah::where('id_jadwal', $isValid['data']->id_jadwal)->update(['status' => '-']);
            $kelas  = Kelas::where('id_kelas', $isValid['data']->data_pindah->id_kelas)->first();
            
            $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $isValid['data']->id_jadwal)->where('hari', AdminHelper::getToday())->first();
            if($jadwal) {
                event(new JadwalEvent($jadwal));
            }
            event(new HapusEvent($isValid['data']->data_pindah->kode_pindah));
            PindahJadwal::where('id_jadwal', $isValid['data']->id_jadwal)->delete();
        } else {
            Kelas::where('id_kelas', $isValid['data']->id_kelas)->update(['status' => 'nonAktif']);
            JadwalKuliah::where('id_jadwal', $isValid['data']->id_jadwal)->update(['status' => '-']);
            $kelas  = Kelas::where('id_kelas', $isValid['data']->id_kelas)->first();            
            $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $isValid['data']->id_jadwal)->where('hari', AdminHelper::getToday())->first();
            if($jadwal) {
                event(new JadwalEvent($jadwal));
            }
        }
        $data = ['kelas' => $kelas, 'tipe' => 'kelas'];
        event(new StatusEvent($data));
        return redirect('dosen');

    }

    public function destroy(Request $request)
    {
      
        $id = $request->id;
        JadwalKuliah::where('id_jadwal', $request->id_jadwal)->update(['status' => '-']);
      
        $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $request->id_jadwal)->where('hari', AdminHelper::getToday())->first();
        if($jadwal) {
            event(new JadwalEvent($jadwal));
        }
        event(new HapusEvent($request->kode_pindah));
        PindahJadwal::destroy($request->id);

        return response()->json(['data' => 'success']);
    }

}
