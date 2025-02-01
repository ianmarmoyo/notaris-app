<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct()
    {
        $menu = menu_active("user");
        if (isset($menu->menu)) {
            View::share('menu_active', $menu->slug);
            View::share('menu_open', $menu->menu->slug);
        } else {
            View::share('menu_active', $menu);
        }
    }

    /**
     * Find All user.
     */
    public function read(Request $request)
    {
        $start = $request->start;
        $length = $request->length;
        $query = $request->search['value'];
        $sort = $request->columns[$request->order[0]['column']]['data'];
        $dir = $request->order[0]['dir'];
        $search = $request->search['value'];

        $query = User::select('id');
        $query->whereNot('email', 'development@anta.com');
        $query->where(function ($q) use ($search) {
            $q->whereRaw("(
                UPPER(name) like '%" . $search . "%'
                or
                UPPER(email) like '%" . $search . "%')
            ");
        });
        $totals = $query->count();

        $query = User::with('roles');
        // $query = User::whereHas('roles', function ($q) {
        //     $q->pluck('name');
        // });
        $query->whereNot('email', 'development@anta.com');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("(
                    UPPER(name) like '%" . $search . "%'
                    or
                    UPPER(email) like '%" . $search . "%')
                ");
            });
        }
        $query->offset($start);
        $query->limit($length);
        // $query->orderBy($sort, $dir);
        $users = $query->get();

        // $roles = $users->pluck('roles.name')->unique();
        // // dd($roles);
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totals,
            'recordsFiltered' => $totals,
            'data' => $users
        ], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar User';
        $roles = Role::get();

        return view('content.user.index', compact('title', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Buat User';
        return view('content.user.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            "name" => "required",
            "email" => "required|email|unique:users,email",
        ];

        $messageValidation = [
            'name.required' => 'Masukan nama pengguna.',
            'email.required' => 'Masukan alamat email.',
            'email.unique' => 'Alamat email sudah digunakan.',
        ];

        $validator = Validator::make($request->all(), $rules, $messageValidation);
        if ($validator->fails()) {
            return response()->json([
                'status'     => false,
                'message'     => $validator->errors()->first()
            ], 400);
        }

        DB::beginTransaction();

        $dto = $request->except('_token');
        data_set($dto, 'password', Hash::make($request->password));

        $user = User::create($dto);
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
            'route'     => route('admin-user-index')
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Display members and employeess resource.
     */
    public function memberAndEmployee(Request $request)
    {
        $start = $request->page ? $request->page - 1 : 0;
        $length = $request->limit;
        $name = strtoupper($request->name) ?: '';
        $assign_user = $request->assign_user;

        $members = DB::table('members')->select(
            'id',
            'name'
        );
        // if ($name) {
        //     $members->where(function ($q) use ($name) {
        //         $q->whereRaw("(UPPER(name) like '%" . $name . "%' ");
        //     });
        // }
        $membersResult = $members->addSelect(DB::raw("'' AS email, 'member' AS user_type"));

        $employees = DB::table('employees')->select(
            'id',
            'name',
            'email'
        );
        if ($name) {
            $members->where(function ($q) use ($name) {
                $q->where('name', 'LIKE', '%' . $name . '%');
            });
        }
        $employees->orderBy('name', 'ASC');
        $employeesResult = $employees->addSelect(DB::raw("'employee' AS user_type"));

        $results = $employeesResult->unionAll($membersResult)->get();
        $totals = $results->count();

        if ($assign_user) {
            $results = $results->filter(function ($data) use ($assign_user) {
                if ($assign_user == $data->user_type) {
                    return $data;
                }
            });
        }


        $data = [];
        foreach ($results as $row) {
            $row->no = ++$start;
            $data[] = $row;
        }
        return response()->json([
            'recorsTotal' => $totals,
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = __('Ubah User');
        $user = User::with(['member.user', 'employee.user'])->findOrFail($id);

        return view('content.user.edit', compact('title', 'user'));
    }

    /**
     * Show the form for Give Roles For User.
     */
    public function userGiveRole(string $id)
    {
        $title = __('Assign Role User');
        $user = User::with(['member.user', 'employee.user', 'roles'])->findOrFail($id);
        $roles = Role::get();
        $role = Role::where('name',)->first();
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('content.user.userGiveRole', compact('title', 'user', 'roles', 'userRoles'));
    }

    /**
     * Assign Role For User.
     */
    public function giveRole(Request $request, string $uuid)
    {
        $user = User::find($uuid);
        $user->syncRoles($request->roles);
        if (!$user) {
            return response()->json([
                'status'     => false,
                'message'     => $user
            ], 400);
        }

        return response()->json([
            'status'     => true,
            'route'     => route('admin-user-index')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            "name" => "required",
            "email" => "required|email|unique:users,email,$id",
        ];

        $messageValidation = [
            'name.required' => 'Masukan nama pengguna.',
            'email.required' => 'Masukan alamat email.',
            'email.unique' => 'Alamat email sudah digunakan.',
        ];

        if ($request->password) {
            $rules += ['password' => 'required|required_with:password_confirm|same:password_confirm|min:6|max:12'];
            $rules += ['password_confirm' => 'required|min:6|max:12'];
        }

        $validator = Validator::make($request->all(), $rules, $messageValidation);
        if ($validator->fails()) {
            return response()->json([
                'status'     => false,
                'message'     => $validator->errors()->first()
            ], 400);
        }

        DB::beginTransaction();
        $user = User::find($id);

        $dto = $request->except('_token');
        if ($request->password) {
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
            'route'     => route('admin-user-index')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            $delete = User::findOrFail($id);
            $delete->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'status'     => false,
                'message'     => "Data tidak dapat dihapus."
            ], 400);
        }

        return response()->json([
            'status'     => true,
            'message'     => "Data berhasil dihapus."
        ], 200);
    }
}
