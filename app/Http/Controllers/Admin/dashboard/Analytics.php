<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class Analytics extends Controller
{
  function __construct()
  {
    View::share('menu_active', 'analytics');
    View::share('menu_open', 'dashboard');
  }

  public function index()
  {
    return view('content.dashboard.dashboards-analytics');
  }
}
