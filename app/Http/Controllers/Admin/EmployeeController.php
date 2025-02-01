<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
  const PATH_IMAGE = "images/employee/";
  function __construct()
  {
    $menu = menu_active("employee");

    if (isset($menu->menu)) {
      View::share('menu_active', $menu->slug);
      View::share('menu_open', $menu->menu->slug);
    } else {
      View::share('menu_active', $menu);
    }
  }

  public function index()
  {
    $title = "Pegawai";
    return view('content.employee.index', compact('title'));
  }

  public function create()
  {
    $title = "Buat Pegawai Baru";
    return view('content.employee.create', compact('title'));
  }

  public function data(Request $request)
  {
    $start = $request->start;
    $length = $request->length;
    $query = $request->search['value'];
    $sort = $request->columns[$request->order[0]['column']]['data'];
    $dir = $request->order[0]['dir'];
    $search = $request->search['value'];

    $query = Employee::select('id');
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(employees.nama) like '%" . $search . "%'
          OR
          UPPER(employees.no_telp) like '%" . $search . "%'
      )");
    });
    $totals = $query->count();

    $query = Employee::select(
      'employees.*'
    );
    $query->when($search, function ($q) use ($search) {
      $q->whereRaw("(
          UPPER(employees.nama) like '%" . $search . "%'
          OR
          UPPER(employees.no_telp) like '%" . $search . "%'
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

  public function store(EmployeeRequest $request)
  {
    try {
      $guru = Employee::create([
        'nama' => $request->nama,
        'jk' => $request->gender,
        'tgl_lahir' => $request->date_birth,
        'tempat_lahir' => $request->place_of_birth,
        'no_telp' => $request->phone,
        'agama' => $request->religion,
        'alamat' => $request->address,
      ]);


      if ($request->hasFile('foto')) {
        $path = self::PATH_IMAGE . $guru->id;
        $file = $request->foto;

        $storageImage = Storage::putFileAs(
          $path,
          $file,
          str_replace(' ', '-', Str::random(20) . '.' . $file->getClientOriginalExtension())
        );

        $guru->foto = $storageImage;
        $guru->save();
      }

      DB::commit();
      return response()->json([
        'status' => true,
        'message' => 'Data tersimpan',
        'route' => route('admin-employee-index'),
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => 'Gagal menyimpan data',
        'error' => $e->getMessage(),
      ]);
    }
  }

  public function edit(Employee $employee)
  {
    $title = "Edit Pegawai";

    return view('content.employee.edit', compact('title', 'employee'));
  }

  public function detail(Employee $employee)
  {
    $title = "Detail Pegawai";

    return view('content.employee.detail', compact('title', 'employee'));
  }

  public function update(Request $request, Employee $employee)
  {
    try {
      $employee->update([
        'nama' => $request->nama,
        'jk' => $request->gender,
        'tgl_lahir' => $request->date_birth,
        'tempat_lahir' => $request->place_of_birth,
        'no_telp' => $request->phone,
        'agama' => $request->religion,
        'alamat' => $request->address,
      ]);


      if ($request->hasFile('foto')) {
        if ($employee->foto && Storage::exists($employee->foto)) {
          Storage::delete($employee->foto);
        }

        $path = self::PATH_IMAGE . $employee->id;
        $file = $request->foto;

        $storageImage = Storage::putFileAs(
          $path,
          $file,
          str_replace(' ', '-', Str::random(20) . '.' . $file->getClientOriginalExtension())
        );

        $employee->foto = $storageImage;
        $employee->save();
      }

      DB::commit();
      return response()->json([
        'status' => true,
        'message' => 'Data tersimpan',
        'route' => route('admin-employee-index'),
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => 'Gagal menyimpan data',
        'error' => $e->getMessage(),
      ]);
    }
  }
}
