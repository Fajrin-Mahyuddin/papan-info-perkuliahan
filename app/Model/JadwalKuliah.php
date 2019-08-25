<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    protected $table        = 'tbd_jadwal_kuliah';
    protected $primaryKey   = 'id_jadwal';
    protected $fillable     = ['id_dosen', 'id_mk', 'id_kelas', 'id_semester', 'hari', 'jam_mulai', 'jam_akhir', 'status', 'ket'];
    protected $attributes   = [
        'status'      => '-',
        'ket'         => 'aktif',
    ];
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

    public function data_semester()
    {
        return  $this->belongsTo('App\Model\Semester', 'id_semester');
    }

    public function data_pindah()
    {
        return $this->hasOne('App\Model\PindahJadwal', 'id_jadwal');
    }
}
