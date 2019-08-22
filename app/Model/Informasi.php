<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $table        = 'tbd_informasi';
    protected $primaryKey   = 'id_informasi';
    protected $fillable     = ['id_dosen', 'id_semester', 'judul', 'isi_informasi', 'ket'];

    public function data_dosen()
    {
        return $this->belongsTo('App\Model\Dosen', 'id_dosen');
    }

    public function data_semester()
    {
        return $this->belongsTo('App\Model\Semester', 'id_semester');
    }

}
