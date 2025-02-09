<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenurunanHak;
use App\Models\WorkOrderAttachment;
use App\Models\WorkOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class PenurunanHakController extends Controller
{
  const PATH_IMAGE = "penurunan_hak/image/";

  function __construct()
  {
    $menu = menu_active("work-order");

    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
    view()->composer('content.penurunan_hak.*', function ($view) {
      $title = "Penugasan Penurunan Hak";
      $view->with('page_title', 'Penurunan Hak');
      $view->with('title', $title);
    });
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

    $update = PenurunanHak::find($balik_nama_waris_id);
    $update->update([
      'checklist' => $checklist ? 1 : null,
      'catatan' => $catatan,
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
    $procedures = PenurunanHak::with('work_order_assignment')->where('work_order_assignment_id', $work_order_assignment_id)->get();
    $work_order_detail_id = $procedures[0]->work_order_assignment->work_order_detail_id;
    $wo_attachment = WorkOrderAttachment::where('work_order_detail_id', $work_order_detail_id)->get();
    $catatan_pesyaratan = WorkOrderDetail::find($work_order_detail_id)->catatan_persyaratan;
    // dd($wo_attachment);
    return view('content.penurunan_hak.form', compact(
      'procedures',
      'work_order_assignment_id',
      'wo_attachment',
      'catatan_pesyaratan'
    ));
  }

  public function detail($work_order_assignment_id)
  {
    $procedures = PenurunanHak::with('work_order_assignment')->where('work_order_assignment_id', $work_order_assignment_id)->get();
    $work_order_assignment = $procedures[0]->work_order_assignment;
    $wo_attachment = WorkOrderAttachment::where('work_order_detail_id', $work_order_assignment->work_order_detail_id)->get();
    $catatan_pesyaratan = WorkOrderDetail::find($work_order_assignment->work_order_detail_id)->catatan_persyaratan;

    return view('content.penurunan_hak.detail', compact(
      'procedures',
      'work_order_assignment_id',
      'wo_attachment',
      'work_order_assignment',
      'catatan_pesyaratan'
    ));
  }
}
