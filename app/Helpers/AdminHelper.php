<?php

namespace App\Helpers;

use Auth;
use Carbon\Carbon;
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
  
  public static function getToday($tgl = null)
  {
    if($tgl === null) {
      $tgl = now();
    }
    return Carbon::parse($tgl)->isoFormat('dddd');
  }

  // protected $jadwal, $jam_masuk, $jam_keluar, $hari, $kelas;

  public static function validateJadwal($jadwal, $jam_masuk_input, $jam_keluar_input)
  {
 
      foreach($jadwal as $val) {
    
          if($val->jam_mulai) {
            $jam_masuk = $val->jam_mulai;
            $jam_keluar = $val->jam_akhir;
          } else {
            $jam_masuk = $val->jam_mulai_pindah;
            $jam_keluar = $val->jam_akhir_pindah;
          }

          // $jam_masuk_input = $jam_masuk;
          // $jam_keluar_input = $jam_keluar;

          $sub_masuk = substr($jam_masuk_input, 0, 5);
          $time_masuk1  = explode(':', $sub_masuk);
          $time_masuk2  = $time_masuk1[0];
          $time_masuk3  = $time_masuk1[1];
          $masuk = intval($time_masuk2.$time_masuk3);
          
          $sub_keluar = substr($jam_keluar_input, 0, 5);
          $time_keluar1  = explode(':', $sub_keluar);
          $time_keluar2  = $time_keluar1[0];
          $time_keluar3  = $time_keluar1[1];
          $keluar = intval($time_keluar2.$time_keluar3);

          $arr_data = [];
          for ($masuk; $masuk <= $keluar ; $masuk++) { 
              $value = array_push($arr_data, $masuk);
          }

          // validator

          $sub = substr($jam_masuk, 0, 5);
      
          $time2  = explode(':', $sub);
          $time3  = $time2[0];
          $time4  = $time2[1];
          $a = intval($time3.$time4);

          $time20  = explode(':', substr($jam_keluar, 0, 5));
          $time30  = $time20[0];
          $time40  = $time20[1];
          $b = intval($time30.$time40);

          $arr = [];
          for ($x = $a; $x <= $b ; $x++) { 
              $val = array_push($arr, $x);
          }

          $result = array_intersect($arr, $arr_data);
          
          if($result) {
              return false;
              break;
          }

      } //Akhir foreach
    return true;
    
  }

  public static function validatePindah($pindah, $jam_masuk_input, $jam_keluar_input)
  {

    foreach($pindah as $val) {

      $sub_masuk = substr($jam_masuk_input, 0, 5);
      $time_masuk1  = explode(':', $sub_masuk);
      $time_masuk2  = $time_masuk1[0];
      $time_masuk3  = $time_masuk1[1];
      $masuk = intval($time_masuk2.$time_masuk3);
      
      $sub_keluar = substr($jam_keluar_input, 0, 5);
      $time_keluar1  = explode(':', $sub_keluar);
      $time_keluar2  = $time_keluar1[0];
      $time_keluar3  = $time_keluar1[1];
      $keluar = intval($time_keluar2.$time_keluar3);

      $arr_data = [];
      for ($masuk; $masuk <= $keluar ; $masuk++) { 
          $value = array_push($arr_data, $masuk);
      }

      // validator
      $jam_masuk = $val->data_pindah->jam_mulai_pindah;
      $jam_keluar = $val->data_pindah->jam_akhir_pindah;

      $time2  = explode(':', substr($jam_masuk, 0, 5));
      $time3  = $time2[0];
      $time4  = $time2[1];
      $a = intval($time3.$time4);

      $time20  = explode(':', substr($jam_keluar, 0, 5));
      $time30  = $time20[0];
      $time40  = $time20[1];
      $b = intval($time30.$time40);

      $arr = [];
      for ($x = $a; $x <= $b ; $x++) { 
          $val = array_push($arr, $x);
      }

      $result = array_intersect($arr, $arr_data);
      
      if($result) {
          return false;
          break;
      }

    } //Akhir foreach
    return true;
  }

}