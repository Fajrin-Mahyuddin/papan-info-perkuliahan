<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserValidasi extends Model
{
    protected $table        = 'tb_user_validasi';
    protected $primaryKey   = 'id_user_validasi';
    protected $fillable     = ['nama', 'pass', 'ket'];
    protected $attributes   = [
        'ket' => 'aktif'
    ];
    public $timestamps    = false;
}
