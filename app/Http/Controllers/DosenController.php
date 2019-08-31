<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use AdminHelper;
use App\Model\User;
use App\Model\Dosen;
use App\Model\Kelas;
use App\Model\MataKuliah;
use App\Model\JadwalKuliah;
use App\Model\PindahJadwal;
use App\Events\JadwalEvent;
use App\Events\PindahEvent;
use App\Events\StatusEvent;
use App\Events\HapusEvent;
use Illuminate\Http\Request;
use Illuminate\Validator\Rule;

class DosenController extends Controller
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

        return view('dosen.index')->with(['dosen' => $dosen, 'mk' => $mk, 'kelas' => $kelas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('dosen.password');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_password(Request $request)
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generate()
    {
        AdminHelper::toggleStatus();
        $dosen = Dosen::where('id_dosen', Auth::user()->data_dosen->id_dosen)->first();
        $data = ['dosen' => $dosen, 'tipe' => 'dosen'];
        event(new StatusEvent($data));
        // if(Auth::user()->data_dosen->status === 'nonAktif') {

            // $arr_jadwal = [];
            // $jadwal = JadwalKuliah::where('id_dosen', Auth::user()->data_dosen->id_dosen)->get();
            // foreach($jadwal as $val) {
            //     $value = array_push($arr_jadwal, $val->id_jadwal);
            // }
            // if($jadwal) {
            //     JadwalKuliah::whereIn('id_jadwal', $arr_jadwal)->where('status', 'masuk')->update(['status' => '-']);
            //     PindahJadwal::whereIn('id_jadwal', $arr_jadwal)->where('ket', 'masuk')->delete();
            // }
        //         $hari = \Carbon\Carbon::parse(now())->isoFormat('dddd');
        //         // $pindah = PindahJadwal::with(['data_jadwal', 'data_jadwal.data_mk', 'data_jadwal.data_dosen', 'data_kelas'])->get();
        //         $jadwals = JadwalKuliah::with(['data_mk', 'data_dosen', 'data_kelas'])->whereIn('id_jadwal', $arr_jadwal)->where('hari', $hari)->get();
        //         foreach($jadwals as $jadwal) {
        //             event(new JadwalEvent($jadwal));
        //             if($jadwal->data_pindah){event(new HapusEvent($jadwal->data_pindah->id_pindah));};
        //         }
        //     }
        // }
            
        return redirect()->back();
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
    public function destroy($id)
    {
        //
    }
}
