<?php

namespace App\Http\Controllers;

use App\Model\Semester;
use Validator;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SemesterController extends Controller
{
    public function index()
    {
        $data = Semester::where('ket', 'aktif')->first();
        if($data === null) {
            $data = new Semester;
            $data->tahun_semester = '-/-';
            $data->status = 'nonAktif';
            $data->ket = '-';
        }
        return view('administrator.semester.index')->with('data', $data);
    }

    public function ajaxData()
    {
        $data   = Semester::orderBy('id_semester', 'ASC')->get();
        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('status', function($data) {
                                ($data->status === 'aktif') ? $val = ['toggle-on', 'on'] : $val = ['toggle-off', 'off'];

                                return '<a href="#" data-id="'.$data->id_semester.'" data-tahun_semester="'.$data->tahun_semester.'" class="btn-active-'.$val[1].'"><i class="fa fa-'.$val[0].'"></i> ' .$data->status.'</a>';
                            })->addColumn('aksi', function($data) {
                                return '
                                        <a href="#" data-id="'.$data->id_semester.'" data-tahun_semester="'.$data->tahun_semester.'" data-ket="'.$data->ket.'" data-status="'.$data->status.'" class="btn-edit-action"><i class="fa fa-pencil"></i></a> | 
                                        <a href="#" data-id="'.$data->id_semester.'" data-tahun_semester="'.$data->tahun_semester.'" class="btn-delete-action"><i class="fa fa-trash"></i></a>
                                ';
                            })->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'tahun_pertama'    => 'required',
            'tahun_kedua'      => 'required',
            'ket'              => 'required'
        ]);

        if($validate->fails()) {
            return response()->json(['error' => $validate->getMessageBag()->toArray()]);
        }
        $check = Semester::where('id_semester', $request->id_semester)->where('status', 'aktif')->first();
        if($check) {
            return response()->json(['others' => 'Tahun ajaran ini sedang aktif !']);
        }

        $tahun_semester = $request->tahun_pertama.'/'.$request->tahun_kedua;
        Semester::updateOrCreate([
            'id_semester'     =>$request->id_semester
        ],[
            'tahun_semester'  => $tahun_semester,
            'status'          => 'nonAktif',
            'ket'             => $request->ket,
        ]);

        return response()->json(['success' => 'Success !']);
    }

    public function aktif(Request $request)
    {
        Semester::where('status', 'aktif')->update([ 'status' => 'nonAktif' ]);
        Semester::where('id_semester', $request->id_semester)->update([ 'status' => 'aktif' ]);

        return response()->json(['success' => 'Success !']);
    }

    public function destroy(Request $request)
    {
        $check = Semester::where('id_semester', $request->id_semester)->first();
        if($check->status === 'aktif') {
            return response()->json(['others' =>  'Tahun ajaran ini sedang aktif !']);
        }
        Semester::destroy($request->id_semester);
        return response()->json(['success' => 'Success !']);
    }

}
