<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigSales;
use App\Models\Editor;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
  function __construct()
  {
    $menu = menu_active("profile");

    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index()
  {
    $user = Auth::guard('admin')->user();
    $guru = Guru::where('admin_id', $user->id)->first();
    $title = __('Profil');

    return view('content.profile.index', compact('title', 'user', 'guru'));
  }
}
