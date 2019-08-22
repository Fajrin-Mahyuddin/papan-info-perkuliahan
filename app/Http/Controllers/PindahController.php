<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Model\Kelas;
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
                                    ->addColumn('aksi', function($data) {
                                        return '<a href="#" class="btn-edit-active"><i class="fa fa-pencil"></i></a>';
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
        dd($request->all());
    }
}
