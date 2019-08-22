<?php

namespace App\Http\Controllers;

use DataTables;
use Validator;
use App\Model\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class MkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxMk()
    {
        $data = MataKuliah::all();
        
        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('aksi', function($data) {
                                return '<a href="#" data-id="'.$data->id_mk.'" data-kode="'.$data->kode.'" data-nama="'.$data->nama.'" data-sks="'.$data->sks.'" data-ket="'.$data->ket.'" class="btn-edit-action"><i class="fa fa-pencil"></i></a> | <a href="#" data-id="'.$data->id_mk.'" data-nama="'.$data->nama.'" class="btn-delete-action"><i class="fa fa-trash"></i></a>';
                            })->escapeColumns([])
                            ->make(true);
    }

    public function index()
    {
        return view('administrator.mk.daftar');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $msg = [
            'required'  => 'Semua form wajib diisi !',
            'unique'    => 'Kode sudah digunakan'
        ];

        $val = Validator::make($request->all(), [
            'kode'         => [
                'required',
                Rule::unique('tbm_mata_kuliah')->ignore($request->id_mk, 'id_mk'),
            ],
            'nama'  => 'required',
            'sks'   => 'required'
        ], $msg);

        if($val->fails()){
            return response()->json(['error' => $val->getMessageBag()->toArray()]);
        }

        $data = MataKuliah::updateOrCreate(
        [
            'id_mk' => $request->id_mk
        ],
        [
            'kode'  => $request->kode,
            'nama'  => $request->nama,
            'sks'   => $request->sks,
            'ket'   => $request->ket
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
        // $id = base64_decode($id);
        // $data = MataKuliah::find($id);
        // return view('administrator.mk.edit')->with('data', $data);
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
        MataKuliah::destroy($request->id_mk);
        return response()->json(['success' => 'Success !']);
    }
}
