<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class SerialNumberHelper
{
  public static function code($table_name = null, $table_code = null, $table_column = null, $column_length = null)
  {
    $row = DB::table($table_name)->whereRaw("$table_column like '%$table_code%'")->count();

    $length_code = strlen($table_code);
    $start = $length_code + 1;
    $count = $column_length - $length_code;

    if ($row >= 1) {
      $read =  DB::table($table_name)
        ->selectRaw("MAX(substring($table_column,$start,$count)) as max")
        ->where($table_column, 'like', '%' . $table_code . '%')
        ->get();
      foreach ($read as $row) {
        $number = intval($row->max);
      }
    } else {
      $number = 0;
    }

    $number++;
    $tmp = "";
    for ($i = 0; $i < ($column_length - $length_code - strlen($number)); $i++) {
      $tmp = $tmp . "0";
    }
    return strval($table_code . $tmp . $number);
  }
}
