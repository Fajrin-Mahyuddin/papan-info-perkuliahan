<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table        = 'tbm_mata_kuliah';
    protected $primaryKey   = 'id_mk';
    protected $fillable     = ['kode', 'nama', 'sks', 'ket'];
    public $timestamps      = false;
}
