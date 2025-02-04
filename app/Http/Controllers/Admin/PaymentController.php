<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkOrderPaymentRequest;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use App\Models\WorkOrderPayment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PaymentController extends Controller
{
  function __construct()
  {
    $menu = menu_active("payment");
    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index()
  {
    $title = "Pembayaran";
    return view('content.payment.index', compact('title'));
  }

  public function data(Request $request)
  {
    $start = $request->start;
    $length = $request->length;
    $query = $request->search['value'];
    $sort = $request->columns[$request->order[0]['column']]['data'];
    $dir = $request->order[0]['dir'];
    $search = $request->search['value'];

    $query = WorkOrderPayment::select('id');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(work_orders.nama) like '%" . $search . "%'
          OR
          UPPER(work_orders.no_telp) like '%" . $search . "%'
      )");
    });
    $totals = $query->count();

    $query = WorkOrderPayment::select(
      'work_order_payments.*',
      'work_orders.no_wo',
      'work_orders.nama as nama_klien',
      'work_orders.no_telp as no_telp_klien',
    );
    $query->leftJoin('work_orders', 'work_order_payments.work_order_id', 'work_orders.id');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(work_orders.nama) like '%" . $search . "%'
          OR
          UPPER(work_orders.no_telp) like '%" . $search . "%'
      )");
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

  public function selectRequestWorkOrder(Request $request)
  {
    $start = $request->page ? $request->page - 1 : 0;
    $length = $request->limit;
    $search = strtoupper($request->name) ?? '';

    $data = WorkOrder::with('work_order_details')->when($search, function ($query, $search) {
      return $query->where('nama', 'like', '%' . $search . '%');
    })
      ->where('status_wo', 'ready_to_work')
      ->paginate(10, ['*'], 'page', $start);

    return response()->json([
      'results' => $data->items(),
      'pagination' => [
        'more' => $data->hasMorePages()
      ],
    ]);
  }
  public function create()
  {
    $title = "Buat Pembayaran";
    return view('content.payment.create', compact('title'));
  }

  public function store(WorkOrderPaymentRequest $request)
  {
    try {
      DB::beginTransaction();
      $data = $request->except('_token');
      $wo_pay = WorkOrderPayment::create([
        'work_order_id' => $data['work_order_id'],
        'nominal' => $data['amount'],
        'tgl_bayar' => $data['tgl_pembayaran'],
        'metode_pembayaran' => $data['metode_pembayaran'],
        'status_pembayaran' => '1'
      ]);

      $getTagihan = WorkOrderDetail::where('work_order_id', $data['work_order_id'])->sum('harga');
      if ($wo_pay->sum('nominal') === $getTagihan) {
        $wo_pay->work_order->update([
          'status_pembayaran' => 'lunas'
        ]);
      }

      DB::commit();
      return response()->json([
        'status' => true,
        'message' => 'Berhasil melakukan pembayaran',
        'route' => route('admin-payment-index')
      ], 200);
    } catch (Exception $th) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => 'Gagal melakukan pembayaran',
        'error' => $th->getMessage()
      ], 400);
    }
  }

  public function getworkorderpayment(Request $request)
  {
    $work_order_id = $request->work_order_id;
    $work_order_payment = WorkOrderPayment::select(
      'work_order_payments.*',
    )->where('work_order_id', $work_order_id)->get();

    return response()->json([
      'status' => true,
      'data' => $work_order_payment,
      'sisa_tagihan' => $work_order_payment->sum('nominal')
    ], 200);
  }

  public function detail($id)
  {
    $title = "Detail Pembayaran";
    $payment = WorkOrderPayment::with(
      'work_order.work_order_details',
      'work_order.work_order_payments',
    )->where('id', $id)->first();

    return view('content.payment.detail', compact('title', 'payment'));
  }
}
