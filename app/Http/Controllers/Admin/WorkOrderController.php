<?php

namespace App\Http\Controllers\Admin;

use App\Actions\InsertWorkOrderProcedureAction;
use App\Enums\StatusAssignmentEnum;
use App\Helpers\RouteMappingWorkOrderHelper;
use App\Http\Controllers\Controller;
use App\Models\WorkOrderAssignment;
use App\Models\WorkOrderDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PDO;

class WorkOrderController extends Controller
{
  function __construct()
  {
    $menu = menu_active("work-order");
    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index()
  {
    $title = "Daftar Penugasan";
    return view('content.workorder.index', compact('title'));
  }

  public function data(Request $request)
  {
    $start = $request->start;
    $length = $request->length;
    $query = $request->search['value'];
    $sort = $request->columns[$request->order[0]['column']]['data'];
    $dir = $request->order[0]['dir'];
    $search = $request->search['value'];
    $user_admin_id = in_array('notaris', rolesUser()->toArray()) ? auth()->user()->id : false;

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
          UPPER(clients.no_telp) like '%" . $search . "%'
          OR
          UPPER(work_order_details.keperluan) like '%" . $search . "%'
          OR
          UPPER(admins.name) like '%" . $search . "%'
      )");
    });
    $query->when($user_admin_id, function ($q) use ($user_admin_id) {
      $q->where('work_order_assignments.user_admin_id', $user_admin_id);
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
          UPPER(clients.nama) like '%" . $search ."%'
          OR
          UPPER(clients.no_telp) like '%" . $search . "%'
          OR
          UPPER(work_order_details.keperluan) like '%" . $search . "%'
          OR
          UPPER(admins.name) like '%" . $search . "%'
      )");
    });
    $query->when($user_admin_id, function ($q) use ($user_admin_id) {
      $q->where('work_order_assignments.user_admin_id', $user_admin_id);
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

  public function assignment(Request $request)
  {
    $work_order_id = $request->work_order_id;
    $work_order_detail_id = $request->work_order_detail_id;
    $user_admin_id = $request->user_admin_id;

    try {
      DB::beginTransaction();
      $wo_assignment = WorkOrderAssignment::create([
        'work_order_id' => $work_order_id,
        'work_order_detail_id' => $work_order_detail_id,
        'user_admin_id' => $user_admin_id,
        'tgl_penugasan' => now(),
        'status_penugasan' => StatusAssignmentEnum::ON_PROCESS
      ]);

      $action = new InsertWorkOrderProcedureAction();
      $result = $action->execute($wo_assignment);

      if (!$result) {
        DB::rollBack();
        return response()->json([
          'status' => false,
          'message' => 'Work Order Assignment Failed',
          'error' => $result
        ], 500);
      }

      WorkOrderDetail::find($work_order_detail_id)->update(['status' => 'proses']);

      DB::commit();
      return response()->json([
        'status' => true,
        'message' => 'Work Order Assignment Successfully',
        'route' => route('admin-workorder-detail', ['id' => $wo_assignment->id])
      ], 200);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => 'Work Order Assignment Failed',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function assignmentDone(Request $request)
  {
    $wo_assignment_id = $request->wo_assignment_id;
    $wo_assignment = WorkOrderAssignment::find($wo_assignment_id);
    $wo_assignment->status_penugasan = StatusAssignmentEnum::DONE;
    $wo_assignment->save();

    $wo_assignment->work_order_detail->update(['status' => 'selesai']);

    return response()->json([
      'status' => true,
      'message' => 'Penugasan telah selesai',
      'route' => route('admin-workorder-index')
    ], 200);
  }

  public function detail($id)
  {
    $wo_assignment = WorkOrderAssignment::with('work_order_detail.master_work_order')->findOrFail($id);
    $slug = $wo_assignment->work_order_detail->master_work_order->slug;
    $route = RouteMappingWorkOrderHelper::slugWorkOrder($slug);
    if (!$route) {
      abort(404);
    }
    return redirect($route . '/' . $wo_assignment->id);
  }

  public function form($id)
  {
    $wo_assignment = WorkOrderAssignment::with('work_order_detail.master_work_order')->findOrFail($id);
    $slug = $wo_assignment->work_order_detail->master_work_order->slug;
    $route = RouteMappingWorkOrderHelper::slugWorkOrder($slug);
    if (!$route) {
      abort(404);
    }
    return redirect($route . '/' . $wo_assignment->id . '/form');
  }
}
