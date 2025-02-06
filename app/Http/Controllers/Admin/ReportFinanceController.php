<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReportFinanceController extends Controller
{
  function __construct()
  {
    $menu = menu_active("reportfinance");

    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index()
  {
    $title = "Laporan Keuangan";
    return view('content.report_finance.index', compact('title'));
  }

  public function data(Request $request)
  {
    $start = $request->start;
    $length = $request->length;
    $query = $request->search['value'];
    $sort = $request->columns[$request->order[0]['column']]['data'];
    $dir = $request->order[0]['dir'];
    $search = $request->search['value'];

    $query = WorkOrder::select('id');
    $query->leftJoin('clients', 'work_orders.client_id', 'clients.id');
    $query->leftJoin('work_order_payments', 'work_orders.id', 'work_order_payments.work_order_id');
    $query->where('work_orders.status_wo', 'ready_to_work');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
            UPPER(clients.nama) like '%" . $search . "%'
          OR
          UPPER(clients.no_telp) like '%" . $search . "%'
      )");
    });
    $totals = $query->count();

    $query = WorkOrder::select(
      'work_orders.*',
      'clients.nama AS nama_klien',
      'work_order_payments.no_pembayaran',
      'work_order_payments.nominal',
      'work_order_payments.tgl_bayar',
    );
    $query->with('work_order_details');
    $query->leftJoin('clients', 'work_orders.client_id', 'clients.id');
    $query->leftJoin('work_order_payments', 'work_orders.id', 'work_order_payments.work_order_id');
    $query->where('work_orders.status_wo', 'ready_to_work');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(clients.nama) like '%" . $search ."%'
          OR
          UPPER(clients.no_telp) like '%" . $search . "%'
      )");
    });
    $query->offset($start);
    $query->limit($length);
    // $query->orderBy($sort, $dir);
    $users = $query->get();

    return response()->json([
      'draw' => $request->draw,
      'recordsTotal' => $totals,
      'recordsFiltered' => $totals,
      'data' => $users
    ], 200);
  }
}
