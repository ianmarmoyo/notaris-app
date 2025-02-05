<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BalikNamaWaris;
use App\Models\WorkOrderAttachment;
use App\Models\WorkOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class BalikNamaWarisController extends Controller
{
  const PATH_IMAGE = "balik_nama_waris/image/";
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

  public function store(Request $request)
  {
    $balik_nama_waris_id = $request->balik_nama_waris_id;
    $checklist = $request->checklist;
    $status_pembayaran = $request->status_pembayaran;
    $tgl_pembayaran = $request->tgl_pembayaran;
    $catatan = $request->catatan;
    $cek_sertifikat = $request->cek_sertifikat;
    $no_berkas = $request->no_berkas;
    $gambar = $request->hasFile('gambar');

    $update = BalikNamaWaris::find($balik_nama_waris_id);
    $update->update([
      'checklist' => $checklist ? 1 : null,
      'status_pembayaran' => $status_pembayaran,
      'no_berkas' => $no_berkas,
      'catatan' => $catatan,
      'cek_sertifikat' => $cek_sertifikat,
      'tgl_bayar' => $tgl_pembayaran,
    ]);

    if ($gambar) {
      if ($update->gambar && Storage::exists($update->gambar)) {
        Storage::delete($update->gambar);
      }

      $file = $request->file('gambar');
      $path = self::PATH_IMAGE . $balik_nama_waris_id;
      $storage = Storage::putFileAs(
        $path,
        $file,
        str_replace(' ', '-', $file->getClientOriginalName())
      );
      $update->update([
        'gambar' => $storage
      ]);
    }

    return response()->json([
      'status' => true,
      'message' => 'Data berhasil diupdate',
    ]);
  }

  public function form($work_order_assignment_id)
  {
    $title = "Penugasan Balik Nama Waris";
    $procedures = BalikNamaWaris::with('work_order_assignment')->where('work_order_assignment_id', $work_order_assignment_id)->get();
    $work_order_detail_id = $procedures[0]->work_order_assignment->work_order_detail_id;
    $wo_attachment = WorkOrderAttachment::where('work_order_detail_id', $work_order_detail_id)->get();
    $catatan_pesyaratan = WorkOrderDetail::find($work_order_detail_id)->catatan_persyaratan;

    return view('content.balik_nama_waris.form', compact(
      'title',
      'procedures',
      'work_order_assignment_id',
      'wo_attachment',
      'catatan_pesyaratan'
    ));
  }

  public function detail($work_order_assignment_id)
  {
    $title = "Penugasan Balik Nama Waris";
    $procedures = BalikNamaWaris::with('work_order_assignment')->where('work_order_assignment_id', $work_order_assignment_id)->get();
    $work_order_assignment = $procedures[0]->work_order_assignment;
    $wo_attachment = WorkOrderAttachment::where('work_order_detail_id', $work_order_assignment->work_order_detail_id)->get();
    $catatan_pesyaratan = WorkOrderDetail::find($work_order_assignment->work_order_detail_id)->catatan_persyaratan;

    return view('content.balik_nama_waris.detail', compact(
      'title',
      'procedures',
      'work_order_assignment_id',
      'wo_attachment',
      'work_order_assignment',
      'catatan_pesyaratan'
    ));
  }
}
