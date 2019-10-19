<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Model\User;
use App\Model\Dosen;
use App\Model\UserValidasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.users.index');
    }

    public function indexMhs()
    {
        return view('administrator.users.mhs');
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
        $validate = Validator::make($request->all(), [
                'username'      => 'required|unique:users,username,'.$request->id,
                'email'         => 'required|email|unique:users,email,'.$request->id,
                'level'         => 'required',
                'nama'          => 'required',
                'nip'           => 'required',
                'no_hp'         => 'required',
                'jabatan'       => 'required',
                'alamat'        => 'required'
        ]);
        
        if($validate->fails()) {
            return response()->json(['error' => $validate->getMessageBag()->toArray()]);
        }

        $user = User::updateOrCreate([
                'id'            =>$request->id
            ],[
                'username'      => $request->username,
                'email'         => $request->email,
                'level'         => $request->level,
                'password'      => bcrypt($request->username),
                'api_token'     => bcrypt($request->email),
        ]);
        $user->data_dosen()->updateOrCreate([
                'id_user'       => $user->id
        ],[
                'id_user'       => $user->id,
                'nama'          => $request->nama,
                'nip'           => $request->nip,
                'no_hp'         => $request->no_hp,
                'jabatan'       => $request->jabatan,
                'alamat'        => $request->alamat,
                'status'        => 'nonAktif',
                'ket'           => 'dosen',
        ]);
        return response()->json(['success' => 'Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxData()
    {
        $data = Dosen::with('data_user')->get();

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('username', function($data) {
                                return $data->data_user->username;
                            })->addColumn('email', function($data) {
                                return $data->data_user->email;
                            })->addColumn('aksi', function($data) {
                                return '<a href="#" data-id="'.$data->data_user->id.'" data-username="'.$data->data_user->username.'" data-nama="'.$data->nama.'" data-nip="'.$data->nip.'" data-email="'.$data->data_user->email.'" data-no_hp="'.$data->no_hp.'" data-jabatan="'.$data->jabatan.'" data-alamat="'.$data->alamat.'" data-level="'.$data->data_user->level.'" class="btn-edit-action"><i class="fa fa-pencil"></i></a> | <a href="#" class="btn-delete-action" data-id="'.$data->data_user->id.'" data-nama="'.$data->nama.'"><i class="fa fa-trash"></i></a>';
                            })->escapeColumns([])->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function storeMhs(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama'         => [
                'required',
                Rule::unique('tb_user_validasi')->ignore($request->id_user_validasi, 'id_user_validasi'),
            ],
            'password'      => 'required',
        ]);
        
        if($validate->fails()) {
            return response()->json(['error' => $validate->getMessageBag()->toArray()]);
        }

        $user = UserValidasi::updateOrCreate([
                'id_user_validasi'     =>$request->id_user_validasi
            ],[
                'nama'          => $request->nama,
                'pass'          => bcrypt($request->password)
        ]);
        
        return response()->json(['success' => 'Success']);
    }
    
    public function ajaxDataMhs()
    {
        $data = UserValidasi::where('ket', 'aktif')->get();

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('aksi', function($data) {
                                return '<a href="#" data-id="'.$data->id_user_validasi.'" data-nama="'.$data->nama.'" class="btn-edit-action"><i class="fa fa-pencil"></i></a> | <a href="#" class="btn-delete-action" data-id="'.$data->id_user_validasi.'" data-nama="'.$data->nama.'"><i class="fa fa-trash"></i></a>';
                            })->escapeColumns([])->make(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMhs(Request $request)
    {
        UserValidasi::destroy($request->id_user_validasi);
        return response()->json(['success' => 'Success !']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::destroy($request->id);
        return response()->json(['success' => 'Success !']);
    }
}
