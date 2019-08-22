<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Model\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.kelas.index');        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxData()
    {
        $data   = Kelas::orderBy('id_kelas', 'asc')->get();
        return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('aksi', function($data) {
                            return '<a href="#" class="btn-edit-action" data-id="'.$data->id_kelas.'" data-kode="'.$data->kode.'" data-nama="'.$data->nama.'" data-ket="'.$data->ket.'"><i class="fa fa-pencil"></i></a> | <a href="#" class="btn-delete-action" data-id="'.$data->id_kelas.'" data-nama="'.$data->nama.'"><i class="fa fa-trash"></i></a>';
                        })->escapeColumns([])->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator  = Validator::make($request->all(), [
            'kode'      => [    'required', 
                                Rule::unique('tbm_kelas')->ignore($request->id_kelas, 'id_kelas')],
            'nama'      => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        Kelas::updateOrCreate([
            'id_kelas'  => $request->id_kelas
        ],[
            'kode'      => $request->kode,
            'nama'      => $request->nama,
            'status'    => 'nonAktif',
            'ket'       => $request->ket
        ]);

        return response()->json(['success' => 'Success !']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Kelas::destroy($request->id_kelas);
        return response()->json(['success' => 'Success !']);
    }
}
