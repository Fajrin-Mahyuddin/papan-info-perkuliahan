<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Model\User;
use App\Model\Kelas;
use App\Model\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Validator\Rule;

class AdminController extends Controller
{

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen  = User::count();
        $mk     = MataKuliah::count();
        $kelas  = Kelas::count();

        return view('administrator.index')->with(['dosen' => $dosen, 'mk' => $mk, 'kelas' => $kelas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function password()
    {
        return view('administrator.password');        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'old_password'  => 'required',
            'new_password'  => 'required',
            're_password'   => 'required|same:new_password'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        User::where('id', Auth::id())->update([
            'password' => bcrypt($request->re_password)
        ]);

        return response()->json(['success' => 'Success !']);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
