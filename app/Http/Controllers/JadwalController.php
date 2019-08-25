<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use DataTables;
use AdminHelper;
use App\Model\Dosen;
use App\Model\Kelas;
use App\Model\MataKuliah;
use App\Events\JadwalEvent;
use App\Model\JadwalKuliah;
use Illuminate\Http\Request;
use Illuminate\Validator\Rule;

class JadwalController extends Controller
{
    public function index()
    {
        $dosen  = Dosen::get()->except(Auth::user()->data_dosen->id_dosen);
        $mk     = MataKuliah::where('ket', 'aktif')->get();
        $kelas  = Kelas::get();
        
        return view('administrator.jadwal.index')->with(['dosens' => $dosen, 'kelass' => $kelas, 'mks' => $mk]);
    }

    public function ajaxData()
    {
        $data  = JadwalKuliah::with(['data_dosen', 'data_mk', 'data_kelas', 'data_semester'])->get();
        // dd($data);

        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('hari', function($data) {
                                        return '<span class="upCaseFont">'.$data->hari.'</span>';
                                    })->addColumn('aksi', function($data) {
                                        return '<a href="'.url('admin/pindah/jadwal/daftar/tambah/'.base64_encode(date('Y/m/d').'-'.$data->id_jadwal.'-')).'" class="btn-edit-action" data-id="'.$data->id_jadwal.'"><i class="fa fa-sign-out"></i> Pindahkan</a> | <a href="#" class="btn-edit-action" data-id="'.$data->id_jadwal.'" data-dosen="'.$data->id_dosen.'" data-mk="'.$data->id_mk.'" data-kelas="'.$data->id_kelas.'" data-hari="'.$data->hari.'" data-semester="'.$data->id_semester.'" data-jam_mulai="'.$data->jam_mulai.'" data-jam_akhir="'.$data->jam_akhir.'"><i class="fa fa-pencil"></i></a> | <a href="#" class="btn-delete-action" data-id="'.$data->id_jadwal.'" data-mk="'.$data->data_mk->nama.'" data-hari="'.$data->hari.'"><i class="fa fa-trash"></i></a>';
                                    })->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen'    => 'required',
            'id_mk'       => 'required',
            'id_kelas'    => 'required',
            'hari'        => 'required',
            'jam_mulai'   => 'required',
            'jam_akhir'   => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }
        if($request->id_semester === null) {
            if(!empty(AdminHelper::getSemester()->id_semester)) {
                $request->id_semester = AdminHelper::getSemester()->id_semester; 
            } else {
                return response()->json(['others' => 'Tahun ajaran masih kosong !']);
            }
        }

        $jadwal = JadwalKuliah::updateOrCreate([
                'id_jadwal'   => $request->id
        ],[
                'id_dosen'    => $request->id_dosen,
                'id_mk'       => $request->id_mk,
                'id_kelas'    => $request->id_kelas,
                'id_semester' => $request->id_semester,
                'hari'        => $request->hari,
                'jam_mulai'   => $request->jam_mulai,
                'jam_akhir'   => $request->jam_akhir,
        ]);
        
        $data = $jadwal->with(['data_mk', 'data_dosen', 'data_kelas'])->where('id_jadwal', $jadwal->id_jadwal)->first();
        
        event(new JadwalEvent($data));

        return response()->json(['success' => 'Success !']);        
    }

    public function destroy(Request $request)
    {
        JadwalKuliah::destroy($request->id);
        return response()->json(['success' => 'Success !']);
    }
}
