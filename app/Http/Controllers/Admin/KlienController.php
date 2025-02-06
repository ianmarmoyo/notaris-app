<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KlienRequest;
use App\Models\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class KlienController extends Controller
{
  function __construct()
  {
    $menu = menu_active("client");

    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index()
  {
    $title = "Klien";
    return view('content.klien.index', compact('title'));
  }

  public function select(Request $request)
  {
    $start = $request->page ? $request->page - 1 : 0;
    $length = $request->limit;
    $search = strtoupper($request->name) ?? '';

    $data = Client::when($search, function ($query, $search) {
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

  public function read(Request $request)
  {
    $start = $request->start;
    $length = $request->length;
    $query = $request->search['value'];
    $sort = $request->columns[$request->order[0]['column']]['data'];
    $dir = $request->order[0]['dir'];
    $search = $request->search['value'];
    $institution_id = $request->institution_id;

    $query = Client::select('clients.*');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(nama) like '%" . $search . "%'
      )");
    });
    $totals = $query->count();

    $query = Client::select('clients.*');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(nama) like '%" . $search . "%'
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

  public function store(KlienRequest $request)
  {
    try {
      $data = $request->except('_token');
      Client::create($data);
    } catch (Exception $th) {
      return response()->json([
        'status' => 'error',
        'message' => 'Data gagal ditambahkan',
        'errror' => $th->getMessage()
      ]);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Data berhasil ditambahkan',
    ]);
  }

  public function detail($id)
  {
    $title = "Detail Klien";
    $client = Client::find($id);
    return view('content.klien.detail', compact('title', 'client'));
  }

  public function update(KlienRequest $request)
  {
    try {
      $data = $request->except('_token');
      Client::where('id', $request->id)->update($data);
    } catch (Exception $th) {
      return response()->json([
        'status' => 'error',
        'message' => 'Data gagal diupdate',
        'errror' => $th->getMessage()
      ]);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Data berhasil diupdate',
    ]);
  }

  public function delete($id)
  {
    try {
      $client = Client::with('work_orders')->find($id);
      if ($client->work_orders) {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak dapat dihapus',
        ]);
      }
      $client->delete();
    } catch (Exception $th) {
      return response()->json([
        'status' => false,
        'message' => 'Data gagal dihapus',
        'errror' => $th->getMessage()
      ]);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Data berhasil dihapus',
    ]);
  }
}
