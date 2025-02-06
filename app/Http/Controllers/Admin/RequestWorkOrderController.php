<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PersyaratanWorkOrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Client;
use App\Models\MasterWorkOrder;
use App\Models\WorkOrder;
use App\Models\WorkOrderAttachment;
use App\Models\WorkOrderDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class RequestWorkOrderController extends Controller
{
  function __construct()
  {
    $menu = menu_active("request-workorder");
    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }

    $this->middleware(['permission:_request-workorder|buat pengajuan|ubah pengajuan|hapus pengajuan'])->only(
      'index',
      'create',
      'store',
      'edit',
      'update',
      'destroy'
    );
  }

  public function index()
  {
    $title = "Pengajuan Keperluan";
    return view('content.requestworkorder.index', compact('title'));
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

  public function select(Request $request)
  {
    $start = $request->page ? $request->page - 1 : 0;
    $length = $request->limit;
    $search = strtoupper($request->name) ?? '';

    $data = WorkOrder::with('work_order_details')->when($search, function ($query, $search) {
      return $query->where('nama', 'like', '%' . $search . '%');
    })
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
    $title = "Pengajuan Keperluan";
    $clients = Client::get();
    return view('content.requestworkorder.create', compact('title', 'clients'));
  }

  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      $wo = WorkOrder::create([
        'client_id' => $request->client_id,
        'status_wo' => $request->status_wo,
        'tgl_pengajuan' => $request->tgl_pengajuan,
        'tgl_pembayaran' => $request->tgl_pembayaran,
        'status_pembayaran' => 'belum lunas',
      ]);

      $route_redirect = route('admin-requestworkorder-index');
      //* Work Order Detail
      foreach ($request->work_order_id as $key => $work_order_id) {

        $master_work_order = MasterWorkOrder::find($work_order_id);

        $work_order_detail = WorkOrderDetail::create([
          'work_order_id' => $wo->id,
          'master_work_order_id' => $master_work_order->id,
          'keperluan' => ucfirst($master_work_order->nama),
          'harga' => $request->amount[$key] ?? 0,
        ]);

        if ($wo->status_wo == 'ready_to_work') {
          $route_redirect = route('admin-requestworkorder-detail', $wo->id);
          //* Pesyaratan Berkas Keperluan
          $persyaratan = PersyaratanWorkOrderHelper::slugWorkOrder($master_work_order->slug);
          if (isset($persyaratan['syarat'])) {
            foreach ($persyaratan['syarat'] as $key => $syarat) {
              if ($syarat) {
                WorkOrderAttachment::create([
                  'work_order_detail_id' => $work_order_detail->id,
                  'nama_lampiran' => ucfirst($syarat),
                  'jenis_berkas' => 'syarat'
                ]);
              }
            }
          }
          if (isset($persyaratan['pelengkap'])) {
            foreach ($persyaratan['pelengkap'] as $key => $syarat) {
              WorkOrderAttachment::create([
                'work_order_detail_id' => $work_order_detail->id,
                'nama_lampiran' => ucfirst($syarat),
                'jenis_berkas' => 'pelengkap'
              ]);
            }
          }
        }
      }

      DB::commit();
      return response()->json([
        'status' => true,
        'message' => 'Data Berhasil Ditambahkan',
        'route' => $route_redirect,
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => 'Gagal mengajukan keperluan',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function edit($id)
  {
    $title = "Ubah Pengajuan Keperluan";
    $work_order = WorkOrder::with(
      'admin',
      'work_order_details.master_work_order',
      'work_order_details.work_order_attachments',
    )->find($id);

    if ($work_order->status_wo == 'ready_to_work') {
      return redirect()->route('admin-requestworkorder-index');
    }

    return view('content.requestworkorder.edit', compact('title', 'work_order'));
  }

  public function detail($id)
  {
    $title = "Detail Pengajuan Keperluan";
    $work_order = WorkOrder::with(
      'admin',
      'work_order_details.master_work_order',
      'work_order_details.work_order_attachments',
      'work_order_details.work_order_assignment',
      'work_order_payments'
    )->findOrFail($id);

    $query = Admin::select('admins.*');
    $query->whereNot('email', 'development@anta.com');
    $user_admins = $query->get();
    return view('content.requestworkorder.detail', compact('title', 'work_order', 'user_admins'));
  }

  public function update(Request $request, $id)
  {
    try {
      DB::beginTransaction();
      $wo = WorkOrder::find($id);
      $wo->update([
        'nama' => $request->nama,
        'no_telp' => $request->no_telp,
        'alamat' => $request->alamat,
        'status_wo' => $request->status_wo,
        'tgl_pengajuan' => $request->tgl_pengajuan,
        'tgl_pembayaran' => $request->tgl_pembayaran,
      ]);

      $route_redirect = route('admin-requestworkorder-index');

      //* Work Order Detail
      foreach ($request->work_order_details_id as $key => $work_order_details_id) {

        $work_order_detail = WorkOrderDetail::find($request->work_order_details_id[$key]);
        $work_order_detail->update([
          'harga' => $request->amount[$key] ?? 0,
        ]);

        if ($wo->status_wo == 'ready_to_work') {
          $route_redirect = route('admin-requestworkorder-detail', $wo->id);
          $master_work_order = MasterWorkOrder::find($work_order_detail->master_work_order_id);

          //* Pesyaratan Berkas Keperluan
          $persyaratan = PersyaratanWorkOrderHelper::slugWorkOrder($master_work_order->slug);
          if (isset($persyaratan['syarat'])) {
            foreach ($persyaratan['syarat'] as $key => $syarat) {
              if ($syarat) {
                WorkOrderAttachment::create([
                  'work_order_detail_id' => $work_order_detail->id,
                  'nama_lampiran' => ucfirst($syarat),
                  'jenis_berkas' => 'syarat'
                ]);
              }
            }
          }
          if (isset($persyaratan['pelengkap'])) {
            foreach ($persyaratan['pelengkap'] as $key => $syarat) {
              WorkOrderAttachment::create([
                'work_order_detail_id' => $work_order_detail->id,
                'nama_lampiran' => ucfirst($syarat),
                'jenis_berkas' => 'pelengkap'
              ]);
            }
          }
        }
      }

      // dd('stop');
      DB::commit();
      return response()->json([
        'status' => true,
        'message' => 'Data Berhasil Diubah',
        'route' => $route_redirect,
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => 'Gagal merubah keperluan',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function updateWorkOrderAttachment(Request $request)
  {
    try {
      WorkOrderAttachment::find($request->work_order_attachments_id)->update([
        'checklist' => $request->checklist
      ]);
      return response()->json([
        'status' => true,
        'message' => 'Data Berhasil Diubah'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => 'Gagal mengubah data',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function updateWorkOrderDetail(Request $request, $work_order_detail_id)
  {
    $update = WorkOrderDetail::find($work_order_detail_id);
    $update->update([
      'catatan_persyaratan' => $request->catatan_persyaratan
    ]);

    return response()->json([
      'status' => true,
      'message' => 'Data Berhasil Diubah'
    ]);
  }

  public function delete($id)
  {
    try {
      $delete = WorkOrder::findOrFaii($id);
      if ($delete->status_wo == 'ready_to_work') {
        return response()->json([
          'status' => false,
          'message' => 'Data Tidak Dapat Dihapus.'
        ], 400);
      }
      $delete->delete();
      return response()->json([
        'status' => true,
        'message' => 'Data Berhasil Dihapus'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => "Data Tidak Dapat Dihapus."
      ], 400);
    }
  }
}
