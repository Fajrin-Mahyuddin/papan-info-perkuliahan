<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('screen', 'ScreenController@index');
Route::get('screen/jadwal/ajaxJadwal', 'ScreenController@ajaxJadwal')->name('screen.jadwal');
Route::get('screen/jadwal/pindah/ajaxPindah', 'ScreenController@ajaxPindah')->name('screen.jadwal.pindah');

Route::get('testing', function() {
    // $data = \App\Model\JadwalKuliah::get();
    // event(new \App\Events\JadwalEvent($data));
    // $options = array(
    //     'cluster' => 'ap1',
    //     'useTLS' => true
    //   );
    //   $pusher = new Pusher\Pusher(
    //     '1670cfe8b56094b466a8',
    //     '00d5624e956ec4d21e80',
    //     '849340',
    //     $options
    //   );
    
    //   $data['message'] = 'hello world';
    //   $pusher->trigger('channel-jadwal', 'event-jadwal', $data);
    return 'ok';
});

Route::get('/', function () {
    return view('login');
})->middleware('guest');

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::post('login/postLogin', 'AuthController@postLogin');
Route::get('logout', 'AuthController@logout');

Route::get('/register', function () {
    // App\Model\User::create([
    //     'username'  => 'fajrin1',
    //     'level'     => 'dosen',
    //     'email'     => 'fajrin1@gmail.com',
    //     'password'  => bcrypt('123'),
    //     'api_token' => bcrypt('123'),
    // ]);
    // return redirect('login')->with(['status' => 'success', 'msg' => 'Register berhasil !']);
    return AdminHelper::getSemester();

});

// Administrator
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'AuthMiddleware:admin']], function() {
    Route::get('/', 'AdminController@index');

    Route::get('password/ubah', 'AdminController@password');
    Route::post('password/update', 'AdminController@update');

    Route::get('jadwal/daftar', 'JadwalController@index');
    Route::post('jadwal/tambah', 'JadwalController@store');
    Route::post('jadwal/ubah', 'JadwalController@store');
    Route::post('jadwal/hapus', 'JadwalController@destroy');
    Route::get('jadwal/daftar/ajaxData', 'JadwalController@ajaxData')->name('jadwal.daftar.ajax');

    Route::get('pindah/jadwal/daftar', 'PindahController@index');
    Route::get('pindah/jadwal/daftar/tambah/{id}', 'PindahController@edit');
    Route::post('pindah/jadwal/daftar/ubah', 'PindahController@update');
    Route::post('pindah/jadwal/daftar/hapus', 'PindahController@destroy');
    Route::get('pindah/jadwal/daftar/ajaxData', 'PindahController@ajaxData')->name('pindah.jadwal.daftar.ajax');

    Route::get('informasi/daftar', 'InformasiController@index');
    Route::post('informasi/tambah', 'InformasiController@store');
    Route::post('informasi/ubah', 'InformasiController@store');
    Route::post('informasi/hapus', 'InformasiController@destroy');
    Route::get('informasi/daftar/ajaxData', 'InformasiController@ajaxData')->name('informasi.daftar.ajax');

    Route::get('dosen/daftar', 'UserController@index');
    Route::post('dosen/tambah', 'UserController@store');
    Route::post('dosen/ubah', 'UserController@store');
    Route::post('dosen/hapus', 'UserController@destroy');
    Route::get('dosen/daftar/ajaxData', 'UserController@ajaxData')->name('dosen.daftar.ajax');

    Route::post('mk/tambah', 'MkController@store');
    Route::post('mk/ubah', 'MkController@store');
    Route::get('mk/daftar', 'MkController@index');
    Route::post('mk/hapus', 'MkController@destroy');
    Route::get('mk/daftar/ajaxMk', 'MkController@ajaxMk')->name('mk.daftar.ajaxMk');
    
    Route::get('kelas/daftar', 'KelasController@index');
    Route::post('kelas/tambah', 'KelasController@store');
    Route::post('kelas/ubah', 'KelasController@store');
    Route::post('kelas/hapus', 'KelasController@destroy');
    Route::get('kelas/daftar/ajaxData', 'KelasController@ajaxData')->name('kelas.daftar.ajax');

    Route::get('semester/daftar', 'SemesterController@index');
    Route::post('semester/tambah', 'SemesterController@store');
    Route::post('semester/ubah', 'SemesterController@store');
    Route::post('semester/hapus', 'SemesterController@destroy');
    Route::post('semester/aktif', 'SemesterController@aktif');
    Route::get('semester/daftar/ajaxData', 'SemesterController@ajaxData')->name('semester.daftar.ajax');

});
    
// Dosen
Route::group(['prefix' => 'dosen', 'middleware' => ['auth', 'AuthMiddleware:dosen']], function() {

    Route::get('/', 'DosenController@index');
    Route::post('generate/status', 'DosenController@generate');
    Route::get('password/ubah', 'DosenController@password');
    Route::post('password/update', 'DosenController@post_password');

    Route::get('jadwal/daftar/ajaxJadwal', 'DataDosenController@ajaxJadwal')->name('dosen.jadwal.daftar.ajax');
    Route::get('jadwal/daftar', 'DataDosenController@jadwalIndex');
    
    Route::get('pindah/jadwal/daftar', 'DataDosenController@pindahIndex');
    Route::get('pindah/jadwal/daftar/tambah/{id}', 'DataDosenController@edit');
    Route::post('pindah/jadwal/daftar/ubah', 'DataDosenController@update');
    Route::post('pindah/jadwal/daftar/hapus', 'DataDosenController@destroy');
    Route::get('pindah/jadwal/daftar/ajaxPindah', 'DataDosenController@ajaxPindah')->name('dosen.pindah.jadwal.daftar.ajax');

    Route::get('profil', function () {
        return view('dosen.profil');
    });
});


