<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminDetail;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;


class UserAdminController extends Controller
{
  function __construct()
  {
    $menu = menu_active("useradmin");
    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $title = 'User Admin';
    $roles = Role::get();

    return view('content.useradmin.index', compact('title', 'roles'));
  }

  public function read(Request $request)
  {
    $start = $request->start;
    $length = $request->length;
    $query = $request->search['value'];
    $sort = $request->columns[$request->order[0]['column']]['data'];
    $dir = $request->order[0]['dir'];
    $search = $request->search['value'];

    $query = Admin::select('id');
    $query->whereNot('email', 'development@anta.com');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(name) like '%" . $search . "%'
          or
          UPPER(email) like '%" . $search . "%')
      ");
    });
    $totals = $query->count();

    $query = Admin::query();
    $query->with('roles');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(name) like '%" . $search . "%'
          or
          UPPER(email) like '%" . $search . "%')
      ");
    });
    $query->offset($start);
    $query->limit($length);
    // $query->orderBy($sort, $dir);
    $users = $query->get();


    return response()->json([
      'draw' => $request->draw,
      'recordsTotal' => $totals,
      'recordsFiltered' => $totals,
      'data' => $users
    ], 200);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $title = 'Add User Admin';
    return view('content.useradmin.create', compact('title'));
  }

  public function select(Request $request){
    $start = $request->page ? $request->page - 1 : 0;
    $length = $request->limit;
    $search = strtoupper($request->name) ?? '';
    $user_admin_id = in_array('notaris', rolesUser()->toArray()) ? auth()->user()->id : false;

    $data = Admin::when($search, function ($query, $search) {
      return $query->where('name', 'like', '%' . $search . '%');
    })
      ->when($user_admin_id, function ($query, $user_admin_id) {
        return $query->where('id', '=', $user_admin_id);
      })
      ->whereNot('email', 'development@anta.com')
      ->paginate(10, ['*'], 'page', $start);

    return response()->json([
      'results' => $data->items(),
      'pagination' => [
        'more' => $data->hasMorePages()
      ],
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "name" => "required",
      "email" => "required|email|unique:admins,email",
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status'     => false,
        'message'     => $validator->errors()->first()
      ], 400);
    }

    DB::beginTransaction();

    $dto = $request->except('_token');
    data_set($dto, 'password', Hash::make($request->password));

    $userAdmin = Admin::create($dto);
    if (!$userAdmin) {
      DB::rollBack();
      return response()->json([
        'status'     => false,
        'message'     => $userAdmin
      ], 400);
    }


    DB::commit();
    return response()->json([
      'status'     => true,
      'route'     => route('admin-useradmin-index')
    ], 200);
  }

  /**
   * Display the specified resource.
   */
  public function show(Admin $admin)
  {
    $title = __('User Admin Details');
    $user = $admin;
    // dd($user);
    return view('content.useradmin.detail', compact('title', 'user'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Admin $admin)
  {
    $title = __('Edit User Admin');
    $user = $admin;
    return view('content.useradmin.edit', compact('title', 'user'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $validator = Validator::make($request->all(), [
      "name" => "required",
      "email" => "required|email|unique:admins,email,$id",
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status'     => false,
        'message'     => $validator->errors()->first()
      ], 400);
    }

    DB::beginTransaction();
    $user = Admin::find($id);

    $dto = $request->except('_token');
    if ($request->password === $user->password) {
      data_set($dto, 'password', Hash::make($request->password));
    }
    data_set($dto, 'password', $user->password);

    $user->update($dto);
    if (!$user) {
      DB::rollBack();
      return response()->json([
        'status'     => false,
        'message'     => $user
      ], 400);
    }


    DB::commit();
    return response()->json([
      'status'     => true,
      'route'     => route('admin-useradmin-index')
    ], 200);
  }


  public function updateadmin(Request $request, $id)
  {
    DB::beginTransaction();
    try {
      $data = Admin::find($id);

      $data->update([
        'name' => $request->name
      ]);

      $updateAdminDetail = $request->except('_token', 'name', '_method', 'photo');
      $data->admin_detail()->updateOrCreate([
        'admin_id' => $id
      ], $updateAdminDetail);


      if ($request->hasFile('photo')) {
        $file_buku = $request->photo;
        $path = "images/editor_photo/" . $id;
        // Store Image Banner Icon
        $storageIcon = Storage::putFileAs(
          $path,
          $file_buku,
          str_replace(' ', '-', $file_buku->getClientOriginalName())
        );

        $data->admin_detail->update([
          'photo' => $storageIcon
        ]);
      }

      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => 'Gagal Update User Admin',
        'error' => $e->getMessage()
      ]);
    }

    return response()->json([
      'status' => true,
      'message' => 'Berahasil Update User Admin',
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $delete = Admin::findOrFail($id);
      $delete->delete();
    } catch (\Throwable $th) {
      return response()->json([
        'status'     => false,
        'message'     => "Admin user cannot be deleted."
      ], 400);
    }

    return response()->json([
      'status'     => true,
      'message'     => "Admin user deleted successfully."
    ], 200);
  }

  /**
   * Show the form for Give Roles For User.
   */
  public function userGiveRole(string $id)
  {
    $title = __('Assign Role User');
    $user = Admin::with(['roles', 'employee'])->findOrFail($id);
    $roles = Role::get();
    $role = Role::where('name',)->first();
    $userRoles = $user->roles->pluck('name')->toArray();
    $employees = Employee::doesntHave('admin')->get();

    return view('content.useradmin.userGiveRole', compact(
      'title',
      'user',
      'roles',
      'userRoles',
      'employees'
    ));
  }

  /**
   * Assign Role For User.
   */
  public function giveRole(Request $request, string $id)
  {
    $user = Admin::find($id);
    if ($request->employee_id) {
      $user->update([
        'employee_id' => $request->employee_id
      ]);
    }
    $user->syncRoles($request->roles);
    if (!$user) {
      return response()->json([
        'status'     => false,
        'message'     => $user
      ], 400);
    }

    return response()->json([
      'status'     => true,
      'route'     => route('admin-useradmin-index')
    ], 200);
  }

  public function is_active(Request $request)
  {
    try {
      $update = Admin::findOrFail($request->id);
      $is_active = $update->is_active;
      $update->update([
        'is_active' => $is_active == 'active' ? 'inactive' : 'active'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'status'     => false,
        'message'     => "Server Error."
      ], 400);
    }

    return response()->json([
      'status'     => true,
      'message'     => "Successfully."
    ], 200);
  }

  public function is_suspend(Request $request)
  {
    try {
      $update = Admin::findOrFail($request->id);
      $is_suspend = $update->is_suspend;
      $update->update([
        'is_suspend' => $is_suspend ? '0' : '1'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'status'     => false,
        'message'     => "Server Error."
      ], 400);
    }

    return response()->json([
      'status'     => true,
      'message'     => "Successfully."
    ], 200);
  }
}
