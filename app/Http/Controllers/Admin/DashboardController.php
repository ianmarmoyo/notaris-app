<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    function __construct()
    {
        View::share('menu_active', 'dashboard');
        View::share('menu_open', 'dashboard');
    }

    public function index()
    {
        return view('content.dashboard.dashboards-analytics');
    }
}
