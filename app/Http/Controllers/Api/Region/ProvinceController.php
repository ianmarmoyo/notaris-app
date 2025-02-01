<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ProvinceController extends Controller
{
    function __construct()
    {
        $menu = menu_active("province");

        if (isset($menu->menu)) {
            View::share('menu_active', $menu->slug);
            View::share('menu_open', $menu->menu->slug);
        } else {
            View::share('menu_active', $menu);
        }
    }

    public function index()
    {
        $title = __('Provinsi');
        return view('content.province.index', compact('title'));
    }

    public function read(Request $request)
    {
        $start = $request->start;
        $length = $request->length;
        $query = $request->search['value'];
        $sort = $request->columns[$request->order[0]['column']]['data'];
        $dir = $request->order[0]['dir'];
        $search = $request->search['value'];

        $query = Province::select('id');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("(
                    UPPER(name) like '%" . $search . "%' 
                )");
            });
        }
        $totals = $query->count();

        $query = Province::select('provinces.*');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("(
                    UPPER(name) like '%" . $search . "%' 
                )");
            });
        }
        $query->offset($start);
        $query->limit($length);
        $query->orderBy($sort, $dir);
        $results = $query->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totals,
            'recordsFiltered' => $totals,
            'data' => $results
        ], 200);
    }

    public function select(Request $request)
    {
        $start = $request->page ? $request->page - 1 : 0;
        $length = $request->limit;
        $name = strtoupper($request->name) ?? '';

        //Count Data
        $query = Province::whereRaw("upper(name) like '%$name%'");
        $recordsTotal = $query->count();

        //Select Pagination
        $query = Province::whereRaw("upper(name) like '%$name%'");
        $query->offset($start * $length);
        $query->limit($length);
        $regions = $query->get();

        $data = [];
        foreach ($regions as $region) {
            $region->no = ++$start;
            $data[] = $region;
        }
        return response()->json([
            'recorsTotal' => $recordsTotal,
            'data' => $data
        ], 200);
    }

    public function create()
    {
        $title = __('Tambah Provinsi');
        return view('content.province.create', compact('title'));
    }

    public function edit(Province $province)
    {
        $title = __('Ubah Provinsi');
        return view('content.province.edit', compact('province', 'title'));
    }

    public function store(Request $request)
    {
        Province::create($request->only('name'));
        return response()->json([
            'status' => true,
            'route' => route('admin-province-index'),
            'message' => "Created Successfully"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $update = Province::find($id);
        $update->update($request->only('name'));

        return response()->json([
            'status' => true,
            'route' => route('admin-province-index'),
            'message' => "Updated Successfully"
        ], 200);
    }

    public function delete($id)
    {
        try {
            $delete = Province::find($id);
            $delete->delete();
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Data Tidak Dapat Dihapus."
            ], 400);
        }

        return response()->json([
            'status' => true,
            'route' => route('admin-province-index'),
            'message' => "Updated Successfully"
        ], 200);
    }
}
