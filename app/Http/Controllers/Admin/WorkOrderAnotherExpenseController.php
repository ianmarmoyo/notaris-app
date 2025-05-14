<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrderAnotherExpense;
use Illuminate\Http\Request;

class WorkOrderAnotherExpenseController extends Controller
{
  public function get($work_order_assignment_id)
  {
    $procedures = WorkOrderAnotherExpense::where('work_order_assignment_id', $work_order_assignment_id)->get();

    return response()->json([
      'status' => count($procedures) > 0 ? true : false,
      'data' => $procedures
    ]);
  }

  public function store(Request $request)
  {
    $work_order_assignment_id = $request->work_order_assignment_id;
    WorkOrderAnotherExpense::where('work_order_assignment_id', $work_order_assignment_id)->delete();
    foreach ($request->nama_biaya as $key => $value) {
      $nama_biaya = $request->nama_biaya[$key];
      $nominal = $request->nominal[$key];
      $catatan = $request->catatan[$key] ?? '';

      WorkOrderAnotherExpense::updateOrCreate([
        'work_order_assignment_id' => $work_order_assignment_id,
        'nama' => $nama_biaya,
      ], [
        'work_order_assignment_id' => $work_order_assignment_id,
        'nama' => $nama_biaya,
        'nominal' => $nominal,
        'catatan' => $catatan,
      ]);
    }

    return response()->json([
      'status' => true,
      'message' => 'Data berhasil disimpan'
    ]);
  }
}
