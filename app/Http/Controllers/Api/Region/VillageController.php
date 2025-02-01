<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class VillageController extends Controller
{
    function __construct()
    {
        $menu = menu_active("village");

        if (isset($menu->menu)) {
            View::share('menu_active', $menu->slug);
            View::share('menu_open', $menu->menu->slug);
        } else {
            View::share('menu_active', $menu);
        }
    }

    public function index()
    {
        $title = __('Data Desa');
        return view('content.village.index', compact('title'));
    }

    public function read(Request $request)
    {
        $start = $request->start;
        $length = $request->length;
        $query = $request->search['value'];
        $sort = $request->columns[$request->order[0]['column']]['data'];
        $dir = $request->order[0]['dir'];
        $search = strtoupper($request->search['value']) ?? '';

        $query = Village::selectRaw("
            villages.id,
            villages.name,
            districts.name AS district_name
        ");
        $query->leftJoinDistrict();
        $query->when($search, function ($query, $search) {
            $query->whereRaw("(
                upper(villages.name) like '%$search%'
                or
                upper(districts.name) like '%$search%')
            ");
        });
        $totals = $query->count();

        $query = Village::selectRaw("
            villages.id,
            villages.name,
            districts.name AS district_name
        ");
        $query->leftJoinDistrict();
        $query->when($search, function ($query, $search) {
            $query->whereRaw("(
                upper(villages.name) like '%$search%'
                or
                upper(districts.name) like '%$search%')
            ");
        });
        $query->offset($start);
        $query->limit($length);
        $query->orderBy('villages.name', $dir);
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
        $district_id = $request->district_id ?? 0;

        //Count Data
        $query = Village::whereRaw("upper(name) like '%$name%'");
        if ($district_id) {
            $query->where('district_id', $district_id);
        }
        $recordsTotal = $query->count();

        //Select Pagination
        $query = Village::whereRaw("upper(name) like '%$name%'");
        if ($district_id) {
            $query->where('district_id', $district_id);
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
        $title = __('Tambah Desa');
        return view('content.village.create', compact('title'));
    }

    public function edit($id)
    {
        $title = __('Ubah Kota');
        $village = Village::findOrFail($id);
        return view('content.village.edit', compact('village', 'title'));
    }

    public function store(Request $request)
    {
        Village::create($request->only('district_id', 'name'));
        return response()->json([
            'status' => true,
            'route' => route('admin-village-index'),
            'message' => "Created Successfully"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $update = Village::find($id);
        $update->update($request->only('district_id', 'name'));

        return response()->json([
            'status' => true,
            'route' => route('admin-village-index'),
            'message' => "Updated Successfully"
        ], 200);
    }

    public function delete($id)
    {
        try {
            $delete = Village::find($id);
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
