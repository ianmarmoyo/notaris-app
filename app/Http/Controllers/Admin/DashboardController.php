<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\MasterWorkOrder;
use App\Models\WorkOrderAssignment;
use App\Models\WorkOrderDetail;
use App\Models\WorkOrderPayment;
use Illuminate\Http\Request;
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
    $total_pelanggan = $this->totalPelanggan();
    $total_layanan = $this->totalLayanan();
    $total_wo_proses = $this->totalWorkOrderProses();
    $total_wo_selesai = $this->totalWorkOrderSelesai();

    $total_pembayaran = $this->totalPembayaran();
    $total_tagihan_invoice = $this->totalTagihanInvoice();

    return view('content.dashboard.dashboards-analytics', compact(
      'total_pelanggan',
      'total_layanan',
      'total_wo_proses',
      'total_wo_selesai',
      'total_pembayaran',
      'total_tagihan_invoice',
    ));
  }

  public function totalPelanggan()
  {
    $thisMonth = date('m');
    $thisYear = date('Y');

    $clients = Client::whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->count();
    return $clients;
  }

  public function totalLayanan()
  {
    $thisMonth = date('m');
    $thisYear = date('Y');

    $data = WorkOrderAssignment::whereMonth('tgl_penugasan', $thisMonth)
      ->whereYear('tgl_penugasan', $thisYear)
      ->count();
    return $data;
  }

  public function totalWorkOrderSelesai()
  {
    $thisMonth = date('m');
    $thisYear = date('Y');

    $data = WorkOrderAssignment::whereMonth('tgl_penugasan', $thisMonth)
      ->whereYear('tgl_penugasan', $thisYear)
      ->where('status_penugasan', 'Selesai')
      ->count();
    return $data;
  }

  public function totalWorkOrderProses()
  {
    $thisMonth = date('m');
    $thisYear = date('Y');

    $data = WorkOrderAssignment::whereMonth('tgl_penugasan', $thisMonth)
      ->whereYear('tgl_penugasan', $thisYear)
      ->where('status_penugasan', 'Dalam Proses')
      ->count();
    return $data;
  }

  public function totalPembayaran()
  {
    $thisMonth = date('m');
    $thisYear = date('Y');

    $data = WorkOrderPayment::whereMonth('tgl_bayar', $thisMonth)
      ->whereYear('tgl_bayar', $thisYear)
      ->sum('nominal');
    return $data;
  }

  public function totalTagihanInvoice()
  {
    $thisMonth = date('m');
    $thisYear = date('Y');

    $data = WorkOrderDetail::whereMonth('created_at', $thisMonth)
      ->whereYear('created_at', $thisYear)
      ->sum('harga');
    return $data;
  }

  public function dataChartLayananBulanan(Request $request)
  {
    $months = [];
    $currentMonth = date('m');
    $currentYear = date('Y');
    $status_penugasan = $request->status_penugasan;
    $monthNames = [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus",
      "September",
      "Oktober",
      "November",
      "Desember"
    ];

    $months = [];
    $data = [];

    for ($i = 1; $i <= 12; $i++) {
      $month = date("m", mktime(0, 0, 0, $i, 1));
      $months[] = $monthNames[$i - 1];

      $result = WorkOrderAssignment::whereMonth('tgl_penugasan', $month)
        ->whereYear('tgl_penugasan', $currentYear)
        ->where('status_penugasan', $status_penugasan)
        ->count() ?? 0;

      $data[] = $result;
    }

    $labels = $months;

    return compact('labels', 'data');
  }

  public function dataChartLayananTahunan(Request $request)
  {
    $years = [];
    $currentYear = date('Y');
    $status_penugasan = $request->status_penugasan;

    for ($i = 4; $i >= 0; $i--) {
      $years[] = $currentYear - $i;
    }

    $data = [];
    foreach ($years as $year) {

      $result = WorkOrderAssignment::whereYear('tgl_penugasan', $year)
        ->where('status_penugasan', $status_penugasan)
        ->count();

      $data[] = $result;
    }

    $labels = $years;
    return compact('labels', 'data');
  }
}
