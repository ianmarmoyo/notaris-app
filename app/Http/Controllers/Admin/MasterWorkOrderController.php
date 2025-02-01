<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterWorkOrder;
use Illuminate\Http\Request;
use PersyaratanWorkOrderHelper;

class MasterWorkOrderController extends Controller
{
  public function select(Request $request){
    $start = $request->page ? $request->page - 1 : 0;
    $length = $request->limit;
    $search = strtoupper($request->name) ?? '';

    $data = MasterWorkOrder::when($search, function ($query, $search) {
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
}
