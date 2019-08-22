<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PindahJadwal extends Model
{
    protected $table        = 'tbd_pindah_jadwal';
    protected $primaryKey   = 'id_pindah';
    protected $fillable     = ['id_jadwal', 'id_kelas', 'hari_pindah', 'jam_mulai_pindah', 'jam_akhir_pindah', 'tgl_pindah', 'ket'];

    public function data_jadwal()
    {
        return $this->belongsTo('App\Model\JadwalKuliah');
    }

    public function data_kelas()
    {
        return $this->belongsTo('App\Model\Kelas');
    }

}
