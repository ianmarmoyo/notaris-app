<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReportWorkOrderController extends Controller
{
  function __construct()
  {
    $menu = menu_active("reportworkorder");

    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index()
  {
    $title = "Laporan Keperluan";
    return view('content.report_workorder.index', compact('title'));
  }

  public function data(Request $request)
  {
    $start = $request->start;
    $length = $request->length;
    $query = $request->search['value'];
    $sort = $request->columns[$request->order[0]['column']]['data'];
    $dir = $request->order[0]['dir'];
    $search = $request->search['value'];
    $client_id = $request->client_id;

    $query = WorkOrder::select('id');
    $query->leftJoin('clients', 'clients.id', '=', 'work_orders.client_id');
    $query->whereDoesntHave('work_order_details', function ($q) {
      $q->where('status', 'proses')->orWhere('status', 'pending');
    });
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(clients.nama) like '%" . $search . "%'
          OR
          UPPER(clients.no_telp) like '%" . $search . "%'
      )");
    });
    $query->when($client_id, function ($q) use ($client_id) {
      $q->where('clients.id', $client_id);
    });
    $totals = $query->count();

    $query = WorkOrder::select(
      'work_orders.*',
      'clients.nama',
    );
    $query->leftJoin('clients', 'clients.id', '=', 'work_orders.client_id');
    $query->whereDoesntHave('work_order_details', function ($q) {
      $q->where('status', 'proses')->orWhere('status', 'pending');
    });
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(clients.nama) like '%" . $search . "%'
          OR
          UPPER(clients.no_telp) like '%" . $search . "%'
      )");
    });
    $query->when($client_id, function ($q) use ($client_id) {
      $q->where('clients.id', $client_id);
    });
    $query->offset($start);
    $query->limit($length);
    $query->orderBy($sort, $dir);
    $users = $query->get();

    return response()->json([
      'draw' => $request->draw,
      'recordsTotal' => $totals,
      'recordsFiltered' => $totals,
      'data' => $users
    ], 200);
  }
}
