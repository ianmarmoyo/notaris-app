<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Models\Regencie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RegencieController extends Controller
{
    function __construct()
    {
        $menu = menu_active("regencie");

        if (isset($menu->menu)) {
            View::share('menu_active', $menu->slug);
            View::share('menu_open', $menu->menu->slug);
        } else {
            View::share('menu_active', $menu);
        }
    }

    public function index()
    {
        $title = __('Kota/Kabupaten');
        return view('content.region.index', compact('title'));
    }

    public function read(Request $request)
    {
        $start = $request->start;
        $length = $request->length;
        $query = $request->search['value'];
        $sort = $request->columns[$request->order[0]['column']]['data'];
        $dir = $request->order[0]['dir'];
        $search = strtoupper($request->search['value']) ?? '';
        $province_id = $request->province_id ?: 0;

        $query = Regencie::selectRaw("
            regencies.id,
            regencies.name,
            provinces.name AS province_name
        ");
        $query->leftJoinProvince();
        $query->when($search, function ($query, $search) {
            $query->whereRaw("(
                upper(provinces.name) like '%$search%'
                or
                upper(regencies.name) like '%$search%')
            ");
        });
        $totals = $query->count();

        $query = Regencie::selectRaw("
            regencies.id,
            regencies.name,
            provinces.name AS province_name
        ");
        $query->leftJoinProvince();
        $query->when($search, function ($query, $search) {
            $query->whereRaw("(
                upper(provinces.name) like '%$search%'
                or
                upper(regencies.name) like '%$search%')
            ");
        });
        $query->offset($start);
        $query->limit($length);
        $query->orderBy('regencies.name', $dir);
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
        $province_id = $request->province_id ?: 0;

        //Count Data
        $query = Regencie::whereRaw("upper(name) like '%$name%'");
        if ($province_id) {
            $query->where('province_id', $province_id);
        }
        $recordsTotal = $query->count();

        //Select Pagination
        $query = Regencie::whereRaw("upper(name) like '%$name%'");
        if ($province_id) {
            $query->where('province_id', $province_id);
        }
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
        $title = __('Tambah Kota');
        return view('content.region.create', compact('title'));
    }

    public function edit($id)
    {
        $title = __('Ubah Kota');
        $regencie = Regencie::findOrFail($id);
        return view('content.region.edit', compact('regencie', 'title'));
    }

    public function store(Request $request)
    {
        Regencie::create($request->only('province_id', 'name'));
        return response()->json([
            'status' => true,
            'route' => route('admin-regencie-index'),
            'message' => "Created Successfully"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $update = Regencie::find($id);
        $update->update($request->only('province_id', 'name'));

        return response()->json([
            'status' => true,
            'route' => route('admin-regencie-index'),
            'message' => "Updated Successfully"
        ], 200);
    }

    public function delete($id)
    {
        try {
            $delete = Regencie::find($id);
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
