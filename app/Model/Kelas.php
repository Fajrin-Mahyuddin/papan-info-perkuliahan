<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table        = 'tbm_kelas';
    protected $primaryKey   = 'id_kelas';
    protected $fillable     = ['kode', 'nama', 'status', 'ket'];
    public $timestamps      = false;
}
