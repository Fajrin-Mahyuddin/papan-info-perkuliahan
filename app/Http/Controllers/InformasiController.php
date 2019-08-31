<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use DataTables;
use AdminHelper;
use App\Model\Semester;
use App\Model\Informasi;
use App\Events\InfoEvent;
use Illuminate\Http\Request;
use Illuminate\Validator\Rule;

class InformasiController extends Controller
{
    public function index()
    {
        return view('administrator.informasi.index');
    }

    public function ajaxData()
    {

        $data = Informasi::with('data_dosen', 'data_semester')->get();
        return DataTables::of($data)->addIndexColumn()
                                    ->addColumn('tahun_semester', function($data) {
                                        return $data->data_semester->tahun_semester;
                                    })->addColumn('aksi', function($data) {
                                        return '<a href="#" class="btn-edit-action" data-id="'.$data->id_informasi.'" data-id_semester="'.$data->id_semester.'" data-judul="'.$data->judul.'" data-isi_informasi="'.$data->isi_informasi.'" data-ket="'.$data->ket.'"><i class="fa fa-pencil"></i></a> | <a href="#" data-id="'.$data->id_informasi.'" class="btn-delete-action"><i class="fa fa-trash"></i></a>';
                                    })->escapeColumns([])->make(true);
    }


    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(), [
                'judul'         => 'required',
                'isi_informasi' => 'required',
                'ket'           => 'required'
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

        $info = Informasi::updateOrCreate([
            'id_informasi'  => $request->id_informasi
        ],[
            'judul'         => $request->judul,
            'isi_informasi' => $request->isi_informasi,
            'ket'           => $request->ket,
            'id_dosen'      => Auth::user()->data_dosen->id_dosen,
            'id_semester'   => $request->id_semester
        ]);

        $data = Informasi::where('id_semester', AdminHelper::getSemester()->id_semester)->where('id_informasi', $info->id_informasi)->first();
        if($data) {
            event(new InfoEvent(['info' => $data, 'tipe' => 'ubah']));
        }

        return response()->json(['success' => 'Success !']);
    }

    public function destroy(Request $request)
    {
        Informasi::destroy($request->id_informasi);
        event(new InfoEvent(['info' => $request->id_informasi, 'tipe' => 'hapus']));
        return response()->json(['success' => 'Success !']);
    }

}
