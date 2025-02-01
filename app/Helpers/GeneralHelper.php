<?php

use App\Models\Models\Menu;
use App\Models\SubMenu;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;
use App\Moduls\RaporSiswaModule;

if (!function_exists('getParent')) {
  function getParent($id) {}
}

if (!function_exists('menu_active')) {
  function menu_active($slug)
  {
    $sub_menu = SubMenu::with('menu')->where('slug', $slug)->first();
    return $sub_menu ?: $slug;
  }
}

if (!function_exists('text_success_register')) {
  function text_success_register()
  {
    return 'Welcome to MyChauffeur! Your account has been successfully created. Get ready to enjoy our premium services!';
  }
}

if (!function_exists('generatePhoneIndo')) {
  function generatePhoneIndo($phone)
  {
    // Nomor telepon asli
    $original_number = $phone;

    // Mengganti digit pertama "0" dengan "62"
    $new_number = substr_replace($original_number, "62", 0, 1);

    // Menampilkan nomor telepon yang telah diganti digit pertamanya
    return $new_number; // Output: 6281234567890
  }
}

if (!function_exists('generatePhoneMy')) {
  function generatePhoneMy($phone)
  {
    // Nomor telepon asli Malaysia
    $original_number = $phone;

    // Mengganti digit pertama "0" dengan "60"
    $new_number = substr_replace($original_number, "60", 0, 1);

    // Menampilkan nomor telepon yang telah diganti digit pertamanya
    return $new_number; // Output: 60123456789
  }
}

if (!function_exists('userPermissions')) {
  function userPermissions()
  {
    $user = Auth::guard()->user();
    $roles = ModelsRole::with('permissions')->whereIn('name', $user->roles->pluck('name'))->get();

    $permissions = [];
    foreach ($roles as $role) {
      foreach ($role->permissions->pluck('name') as $permission) {
        $permissions[] = $permission;
      }
    }
    return $permissions;
  }
}

if (!function_exists('isSuperAdmin')) {
  function isSuperAdmin()
  {
    return auth()->user()->roles->pluck('name');
  }
}

if (!function_exists('rolesUser')) {
  function rolesUser()
  {
    return auth()->user()->roles->pluck('name');
  }
}

if (!function_exists('generateInvoice')) {
  function generateInvoice()
  {
    return 'INV' . date('Y') . substr(time(), 2, 8);
  }
}

if (!function_exists('generateReferal')) {
  function generateReferal()
  {
    $unique = false;
    $code = '';
    do {
      $digits = 4;
      $code = randomChart();
      $existingCode = UserDetail::where('kode_referal', $code)->exists();
      if (!$existingCode) {
        $unique = true;
      }
    } while (!$unique);

    return 'REF' . $code;
  }
}

function randomChart($length = 8)
{
  // Karakter yang akan digunakan dalam kode referal
  $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

  // Mengacak karakter untuk membangun kode referal
  $code = '';
  for ($i = 0; $i < $length; $i++) {
    $code .= $characters[rand(0, strlen($characters) - 1)];
  }

  return $code;
}

if (!function_exists('formatRupiah')) {
  function formatRupiah($value)
  {
    return number_format($value, 0, ',', '.');
  }
}

if (!function_exists('tglIndo')) {
  function tglIndo($date, $format = '%A %d %B %Y %H:%M')
  {
    // \Carbon\Carbon::setLocale('id');
    setlocale(LC_ALL, 'IND');
    $tanggal = Carbon::parse($date)->formatLocalized($format);

    return $tanggal;
  }
}

if (!function_exists('months')) {
  function months()
  {
    $month = new stdClass();
    $months =  [];
    for ($i = 1; $i <= 12; $i++) {
      $month = Carbon::create()->day(1)->month(sprintf("%'.02d", $i))->locale('id');
      $month->settings(['formatFunction' => 'translatedFormat']);
      $months[] = (object) [
        'month' => sprintf("%'.02d", $i),
        'name' => $month->format('F'),
      ];
    }
    return $months;
  }
}

if (!function_exists('years')) {
  function years()
  {
    $year = [];
    for ($i = Carbon::now()->addYear()->format('Y'); $i >= 1991; $i--) {
      $year[] = intval($i);
    }
    return $year;
  }
}

if (!function_exists('urlSegmentAfterAdmin')) {
  function urlSegmentAfterAdmin($url = null)
  {
    // Mendapatkan path dari URL
    $parsed_url = parse_url($url, PHP_URL_PATH);

    // Memisahkan path berdasarkan "/"
    $parts = explode('/', $parsed_url);

    // Mencari indeks dari "admin"
    $admin_index = array_search('admin', $parts);

    // Menggabungkan bagian setelah "admin"
    if ($admin_index !== false && $admin_index < count($parts) - 1) {
      $result = implode('/', array_slice($parts, $admin_index + 1));
      return $result;
    } else {
      return false;
    }
  }
}

if (!function_exists('dateFormatID')) {
  function dateFormatID($date, $format = 'dddd, D MMMM Y H:s')
  {
    setlocale(LC_ALL, 'IND');
    $tanggal = Carbon::parse($date)->isoFormat($format);

    return $tanggal;
  }
}
