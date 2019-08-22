<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table        = 'tb_semester';
    protected $primaryKey   = 'id_semester';
    protected $fillable     = ['tahun_semester', 'status', 'ket', 'created_at', 'updated_at'];

    public static function getSemester()
    {
        return $this->tahun_semester;
    }
    
}
