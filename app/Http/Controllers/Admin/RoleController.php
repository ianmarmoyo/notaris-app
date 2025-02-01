<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessPermissionsMenuGroup;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
  function __construct()
  {
    $menu = menu_active("accessroles");

    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index()
  {
    $title = __('Menage Role');
    return view('content.role.index', compact('title'));
  }

  public function store(Request $request)
  {
    DB::beginTransaction();
    $role = Role::create([
      'name' => $request->role,
      'guard_name' => 'admin'
    ]);

    if (!$role) {
      DB::rollBack();
      return response()->json([
        'status' => true,
        'message' => $role,
      ], 400);
    }

    DB::commit();
    return response()->json([
      'status' => true,
      'message' => 'success'
    ], 200);
  }

  public function detail($id)
  {
    $title = __('Tambahkan Hak Akses');
    $role = Role::findOrFail($id);
    $accessMenuGroup = AccessPermissionsMenuGroup::get();
    $menus = Menu::with('access_menu', 'sub_menu.access_menu')->where('is_header', 0)->orderBy('sort', 'ASC')->get();
    $userPermissions = $role->permissions->pluck('name')->toArray();
    // dd($menus);
    // dd($menus->toArray());
    return view('content.role.detail', compact('title', 'role', 'menus', 'userPermissions'));
  }

  public function read(Request $request)
  {
    $start = $request->start;
    $length = $request->length;
    $query = $request->search['value'];
    $sort = $request->columns[$request->order[0]['column']]['data'];
    $dir = $request->order[0]['dir'];
    $search = $request->search['value'];

    $query = Role::select('id');
    $query->whereNot('name', 'superadmin');
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->whereRaw("(
                    UPPER(name) like '%" . $search . "%'
                ");
      });
    }
    $totals = $query->count();

    $query = Role::select('roles.*');
    $query->whereNot('name', 'superadmin');
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->whereRaw("(
                    UPPER(name) like '%" . $search . "%'
                ");
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
    $search = strtoupper($request->name) ?? '';

    //Count Data
    $query = Role::select('id');
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->whereRaw("(
                    UPPER(name) like '%" . $search . "%'
                ");
      });
    }
    $recordsTotal = $query->count();

    $query = Role::select('Roles.*');
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->whereRaw("(
                    UPPER(name) like '%" . $search . "%'
                ");
      });
    }
    $query->offset($start * $length);
    $query->limit($length);
    $results = $query->get();

    return response()->json([
      'recorsTotal' => $recordsTotal,
      'data' => $results
    ], 200);
  }

  public function updatePermissions(Request $request)
  {
    $role = Role::where('name', $request->role)->first();
    $role->syncPermissions($request->permissions);

    return response()->json([
      'status' => true,
      'message' => 'Hak Akses Diperbarui.'
    ], 200);
  }
}
