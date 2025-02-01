<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessPermissionsMenuGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccessPermissionController extends Controller
{
  function __construct()
  {
    $menu = menu_active("accessPermission");

    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index()
  {
    $title = __('Buat Hak Akses');
    return view('content.accessPermision.index', compact('title'));
  }

  public function read(Request $request)
  {
    $start = $request->start;
    $length = $request->length;
    $query = $request->search['value'];
    $sort = $request->columns[$request->order[0]['column']]['data'];
    $dir = $request->order[0]['dir'];
    $search = $request->search['value'];

    $query = Permission::select('id');
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->whereRaw("(
                    UPPER(name) like '%" . $search . "%'
                ");
      });
    }
    $totals = $query->count();

    $query = Permission::with('roles')->select('permissions.*');
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

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "name" => "required|unique:permissions,name",
    ], [
      'name.required' => 'Masukan nama pengguna.',
      'name.unique' => 'Nama akses sudah digunakan.',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status'     => false,
        'message'     => $validator->errors()->first()
      ], 400);
    }

    DB::beginTransaction();

    $name = $request->accessForMenu == 'parent' ? '_' . $request->name : $request->name;
    $permission = Permission::create([
      'name' => $name,
      'guard_name' => 'admin'
    ]);

    if (!$permission) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => $permission
      ], 400);
    }

    $menuGroup = AccessPermissionsMenuGroup::create([
      'permission_id' => $permission->id,
      'menu_id' => $request->parent_menu_id ?: $request->child_menu_id,
      'type_menu' => $request->accessForMenu
    ]);

    if (!$menuGroup) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => $menuGroup
      ], 400);
    }

    DB::commit();
    return response()->json([
      'status' => true,
      'message' => 'successs'
    ], 200);
  }

  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "name" => "required|unique:permissions,name,". $request->id,
    ], [
      'name.required' => 'Masukan nama pengguna.',
      'name.unique' => 'Nama akses sudah digunakan.',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status'     => false,
        'message'     => $validator->errors()->first()
      ], 400);
    }

    $id = $request->id;
    $name = $request->name;

    DB::beginTransaction();

    $permission = Permission::find($id);
    $permission->update([
      'name' => $name,
    ]);

    if (!$permission) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => $permission
      ], 400);
    }

    DB::commit();
    return response()->json([
      'status' => true,
      'message' => 'successs'
    ], 200);
  }

  public function delete(Request $request)
  {
    $id = $request->id;

    $delete = Permission::find($id);
    $access_permission_menu_group = AccessPermissionsMenuGroup::where('permission_id', $id)->first();
    $access_permission_menu_group->delete();
    $delete->delete();

    return response()->json([
      'status' => true,
      'message' => 'successs'
    ], 200);
  }
}
