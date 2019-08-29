<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use Carbon\Carbon;
use App\Model\Kelas;
use App\Events\HapusEvent;
use App\Events\JadwalEvent;
use App\Events\PindahEvent;
use App\Model\PindahJadwal;
use App\Model\JadwalKuliah;
use Illuminate\Http\Request;

class PindahController extends Controller
{
    public function index()
    {
        return view('administrator.pindah.index');
    }

    public function ajaxData()
    {
        $data   = PindahJadwal::with('data_jadwal', 'data_kelas')->get();

        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('mk', function($data) {
                                        return  $data->data_jadwal->data_mk->nama;
                                    })->addColumn('dosen', function($data) {
                                        if(!empty($data->data_jadwal->data_dosen->nama)){
                                            return  $data->data_jadwal->data_dosen->nama;
                                        }
                                        return  '-';
                                    })->addColumn('aksi', function($data) {
                                        return '<a href="#" data-id="'.$data->id_pindah.'" data-id_jadwal="'.$data->id_jadwal.'" data-nama="'.$data->data_jadwal->data_mk->nama.'" class="btn-delete-action"><i class="fa fa-trash"></i></a>';
                                    })->escapeColumns([])->make(true);
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
            return redirect('admin/jadwal/daftar');
        }

        $kelas = Kelas::get()->except($isValid['data']->id_kelas);  
        
        return view('administrator.pindah.form_pindah')->with(['data' => $isValid['data'], 'kelas' => $kelas]);
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
        $hari = Carbon::parse(now())->isoFormat('dddd');
        $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $pindah->id_jadwal)->where('hari', $hari)->first();
        $pindah = PindahJadwal::with(['data_jadwal', 'data_jadwal.data_mk', 'data_jadwal.data_dosen', 'data_kelas'])->where('id_jadwal', $pindah->id_jadwal)->first();
        if($jadwal){
            event(new JadwalEvent($jadwal));
        }
        event(new PindahEvent($pindah));
        return redirect('admin/pindah/jadwal/daftar')->with('status', 'Success !');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $hari = Carbon::parse(now())->isoFormat('dddd');
        $jadwal = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $request->id_jadwal)->where('hari', $hari)->first();
        $update = JadwalKuliah::where('id_jadwal', $request->id_jadwal)->update(['status' => '-']);
        if($jadwal) {
            event(new JadwalEvent($jadwal));
        }
        event(new HapusEvent($id));
        $delete = PindahJadwal::destroy($request->id);

        return response()->json(['data' => 'data']);
    }
    
}
