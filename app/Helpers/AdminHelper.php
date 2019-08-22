<?php

namespace App\Helpers;

use App\Model\Semester;

class AdminHelper {

  public static function getSemester()
  {
      $take = Semester::where('status', 'aktif')->first();
      
      return $take;
      
  }

}