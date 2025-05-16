<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusAssignmentEnum;
use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\WorkOrderAssignment;
use Carbon\Carbon;
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
    $user_admin_id = in_array('notaris', rolesUser()->toArray()) ? auth()->user()->id : ($request->user_admin_id ?? false);
    $client_id = $request->client_id;
    $employee_admin_id = $request->employee_admin_id;
    $filter = $request->filter;
    $master_work_order_id = $request->master_work_order_id;
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $query = WorkOrderAssignment::select('id');
    $query->leftJoin(
      'work_orders',
      'work_order_assignments.work_order_id',
      'work_orders.id'
    );
    $query->leftJoin(
      'admins',
      'work_order_assignments.user_admin_id',
      'admins.id'
    );
    $query->leftJoin(
      'work_order_details',
      'work_order_assignments.work_order_detail_id',
      'work_order_details.id'
    );
    $query->leftJoin('clients', 'work_orders.client_id', 'clients.id');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(clients.nama) like '%" . $search . "%'
          OR
          UPPER(clients.no_telp) like '%" . $search ."%'
          OR
          UPPER(work_order_details.keperluan) like '%" . $search . "%'
          OR
          UPPER(admins.name) like '%" . $search . "%'
      )");
    });
    $query->when($client_id, function ($q) use ($client_id) {
      $q->where('clients.id', $client_id);
    });
    $query->when($user_admin_id, function ($q) use ($user_admin_id) {
      $q->where('work_order_assignments.user_admin_id', $user_admin_id);
    });
    $query->when($employee_admin_id, function ($q) use ($employee_admin_id) {
      $q->where('work_order_assignments.user_admin_id', $employee_admin_id);
    });
    $query->where('work_order_assignments.status_penugasan', StatusAssignmentEnum::DONE);
    $query->when(($startDate && $endDate), function ($query) use ($startDate, $endDate) {
      $query->whereBetween('work_orders.tgl_pengajuan', [$startDate, $endDate]);
    });
    $query->when($master_work_order_id, function ($q) use ($master_work_order_id) {
      $q->where('work_order_details.master_work_order_id', $master_work_order_id);
    });
    $query->when(($startDate && $endDate), function ($query) use ($startDate, $endDate) {
      $query->whereBetween('work_orders.tgl_pengajuan', [$startDate, $endDate]);
    });
    $totals = $query->count();

    $query = WorkOrderAssignment::select(
      'work_order_assignments.*',
      'work_orders.no_wo',
      'clients.nama AS nama_klien',
      'work_orders.tgl_pengajuan',
      'work_orders.status_wo',
      'admins.name as nama_admin',
      'work_order_details.keperluan'
    );
    $query->leftJoin(
      'work_orders',
      'work_order_assignments.work_order_id',
      'work_orders.id'
    );
    $query->leftJoin('clients', 'work_orders.client_id', 'clients.id');
    $query->leftJoin(
      'admins',
      'work_order_assignments.user_admin_id',
      'admins.id'
    );
    $query->leftJoin(
      'work_order_details',
      'work_order_assignments.work_order_detail_id',
      'work_order_details.id'
    );
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(clients.nama) like '%" . $search . "%'
          OR
          UPPER(clients.no_telp) like '%" . $search ."%'
          OR
          UPPER(work_order_details.keperluan) like '%" . $search . "%'
          OR
          UPPER(admins.name) like '%" . $search . "%'
      )");
    });
    $query->when($employee_admin_id, function ($q) use ($employee_admin_id) {
      $q->where('work_order_assignments.user_admin_id', $employee_admin_id);
    });
    $query->when($client_id, function ($q) use ($client_id) {
      $q->where('clients.id', $client_id);
    });
    $query->when($user_admin_id, function ($q) use ($user_admin_id) {
      $q->where('work_order_assignments.user_admin_id', $user_admin_id);
    });
    $query->where('work_order_assignments.status_penugasan', StatusAssignmentEnum::DONE);
    $query->when($master_work_order_id, function ($q) use ($master_work_order_id) {
      $q->where('work_order_details.master_work_order_id', $master_work_order_id);
    });
    $query->when(($startDate && $endDate), function ($query) use ($startDate, $endDate) {
      $query->whereBetween('work_orders.tgl_pengajuan', [$startDate, $endDate]);
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
