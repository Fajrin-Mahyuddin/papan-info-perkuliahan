<?php

namespace App\Helpers;

use Auth;
use App\Model\Semester;

class AdminHelper {

  public static function getSemester()
  {
      $take = Semester::where('status', 'aktif')->first();
      
      return $take;
      
  }

  public static function toggleStatus()
    {
        $status = Auth::user()->data_dosen->status;
        if( $status === 'aktif') {
          Auth::user()->data_dosen->update(['status' => 'nonAktif']);
        } else {
          Auth::user()->data_dosen->update(['status' => 'aktif']);
        }
    }

}