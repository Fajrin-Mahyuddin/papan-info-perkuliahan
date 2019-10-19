<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table        = 'tbd_absen';
    protected $primaryKey   = 'id_absen';
    protected $fillable     = ['id_dosen', 'id_jadwal', 'id_kelas', 'id_mk', 'jam', 'tanggal', 'ket', 'id_semester'];
    public $timestamps      = false;

    public function data_dosen()
    {
        return $this->belongsTo('App\Model\Dosen', 'id_dosen');
    }

    public function data_mk()
    {
        return $this->belongsTo('App\Model\MataKuliah', 'id_mk');
    }

    public function data_kelas()
    {
        return $this->belongsTo('App\Model\Kelas', 'id_kelas');
    }
}
