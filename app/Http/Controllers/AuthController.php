<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function postLogin(Request $request)
    {

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'level' => 'admin'])) {

            return redirect('admin');

        } elseif(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'level' => 'dosen'])) {

            return redirect('dosen');

        }
    
        return redirect('login')->with(['status' => 'danger', 'msg' => 'Username dan password salah !']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login')->with(['status' => 'success', 'msg' => 'Anda berhasil logout !']);
    }
}
