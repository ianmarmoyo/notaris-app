<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterWorkOrder;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class WorkOrderDeadlineController extends Controller
{
  function __construct()
  {
    $menu = menu_active("workorderdeadline");
    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index(){
    $title = 'Set Deadline Penugasan';
    $workOrders = MasterWorkOrder::get();
    return view('content.workorder_deadline.index', compact('title', 'workOrders'));
  }

  public function store(Request $request)
  {
    foreach($request->master_workorder_id as $key => $id){
      MasterWorkOrder::find($id)->update([
        'day_deadline' => $request->day_deadline[$key]
      ]);
    }

    return redirect()->back()->with('success', 'Set Deadline Penugasan Berhasil');
  }
}
