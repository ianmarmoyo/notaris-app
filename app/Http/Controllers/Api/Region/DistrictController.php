<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Models\District;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DistrictController extends Controller
{
    function __construct()
    {
        $menu = menu_active("district");

        if (isset($menu->menu)) {
            View::share('menu_active', $menu->slug);
            View::share('menu_open', $menu->menu->slug);
        } else {
            View::share('menu_active', $menu);
        }
    }

    public function index()
    {
        $title = __('Data Kecamatan');
        return view('content.district.index', compact('title'));
    }

    public function read(Request $request)
    {
        $start = $request->start;
        $length = $request->length;
        $query = $request->search['value'];
        $sort = $request->columns[$request->order[0]['column']]['data'];
        $dir = $request->order[0]['dir'];
        $search = strtoupper($request->search['value']) ?? '';

        $query = District::selectRaw("
            districts.id,
            districts.name,
            regencies.name AS regencie_name
        ");
        $query->leftJoinRegencie();
        $query->when($search, function ($query, $search) {
            $query->whereRaw("(
                upper(districts.name) like '%$search%'
                or
                upper(regencies.name) like '%$search%')
            ");
        });
        $totals = $query->count();

        $query = District::selectRaw("
            districts.id,
            districts.name,
            regencies.name AS regencie_name
        ");
        $query->leftJoinRegencie();
        $query->when($search, function ($query, $search) {
            $query->whereRaw("(
                upper(districts.name) like '%$search%'
                or
                upper(regencies.name) like '%$search%')
            ");
        });
        $query->offset($start);
        $query->limit($length);
        $query->orderBy('districts.name', $dir);
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
        $regency_id = $request->regency_id ?? 0;

        //Count Data
        $query = District::whereRaw("upper(name) like '%$name%'");
        if ($regency_id) {
            $query->where('regency_id', $regency_id);
        }
        $recordsTotal = $query->count();

        //Select Pagination
        $query = District::whereRaw("upper(name) like '%$name%'");
        if ($regency_id) {
            $query->where('regency_id', $regency_id);
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
        $title = __('Tambah Kecamatan');
        return view('content.district.create', compact('title'));
    }

    public function edit($id)
    {
        $title = __('Ubah Kota');
        $district = District::findOrFail($id);
        return view('content.district.edit', compact('district', 'title'));
    }

    public function store(Request $request)
    {
        District::create($request->only('regency_id', 'name'));
        return response()->json([
            'status' => true,
            'route' => route('admin-district-index'),
            'message' => "Created Successfully"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $update = District::find($id);
        $update->update($request->only('regency_id', 'name'));

        return response()->json([
            'status' => true,
            'route' => route('admin-district-index'),
            'message' => "Updated Successfully"
        ], 200);
    }

    public function delete($id)
    {
        try {
            $delete = District::find($id);
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
