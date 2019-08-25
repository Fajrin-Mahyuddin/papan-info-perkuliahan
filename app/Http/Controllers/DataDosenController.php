<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Model\Kelas;
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

        return redirect('dosen/pindah/jadwal/daftar')->with('status', 'Success !');
    }

    public function ajaxJadwal()
    {
        $data  = JadwalKuliah::with(['data_dosen', 'data_mk', 'data_kelas', 'data_semester'])->where('id_dosen', Auth::user()->data_dosen->id_dosen);
        // dd($data);
        
        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('hari', function($data) {
                                        return '<span class="upCaseFont">'.$data->hari.'</span>';
                                    })->addColumn('aksi', function($data) {
                                        return '<a href="'.url('dosen/pindah/jadwal/daftar/tambah/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn btn-sm btn-success" data-id="'.$data->id_jadwal.'"><i class="fa fa-sign-out"></i> Pindah</a>';
                                    })->escapeColumns([])->make(true);
    }

    public function ajaxPindah()
    {
        $get_jadwal  = JadwalKuliah::where('id_dosen', Auth::user()->data_dosen->id_dosen)->get();
        
        $data_jadwal = [];
        foreach($get_jadwal as $jadwal) {
            $id_jadwal = array_push($data_jadwal, $jadwal->id_jadwal);
        }
        
        $data   = PindahJadwal::whereIn('id_jadwal', $data_jadwal)->get();

        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('mk', function($data) {
                                        return  $data->data_jadwal->data_mk->nama;
                                    })->addColumn('aksi', function($data) {
                                        return '<a href="#" data-id="'.$data->id_pindah.'" data-id_jadwal="'.$data->id_jadwal.'" data-nama="'.$data->data_jadwal->data_mk->nama.'" class="btn-delete-action"><i class="fa fa-trash"></i></a>';
                                    })->escapeColumns([])->make(true);
    }

    public function destroy(Request $request)
    {
        $update = JadwalKuliah::where('id_jadwal', $request->id_jadwal)->update(['status' => '-']);
        $delete = PindahJadwal::destroy($request->id);

        return response()->json(['data' => 'data']);
    }

}
