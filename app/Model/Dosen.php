<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table        = 'tbd_dosen';
    protected $primaryKey   = 'id_dosen';
    protected $fillable     = ['id_user', 'nama', 'nip', 'no_hp', 'jabatan', 'alamat', 'status', 'ket' ];
    public $timestamps      = false;

    public function data_user()
    {
        return $this->belongsTo('App\Model\User', 'id_user');
    }

    public function data_jadwal()
    {
        return $this->hasMany('App\Model\JadwalKuliah', 'id_jadwal');
    }

}
