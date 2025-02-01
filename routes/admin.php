<?php

use App\Http\Controllers\Admin\AccessPermissionController;
use App\Http\Controllers\Admin\BalikAPHBController;
use App\Http\Controllers\Admin\BalikNamaHibahController;
use App\Http\Controllers\Admin\BalikNamaJualBeliController;
use App\Http\Controllers\Admin\BalikNamaSertifikatController;
use App\Http\Controllers\Admin\BalikNamaWarisController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\MasterWorkOrderController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MyAppController;
use App\Http\Controllers\Admin\PemecahSertifikatController;
use App\Http\Controllers\Admin\PendirianPTController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RequestWorkOrderController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorkOrderController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';



Route::middleware(
  'auth:admin',
)->group(function () {

  # DASHBOARD
  Route::group(['prefix' => 'dashboard', 'as' => 'dashboard-'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('analytics');
  });

  # MENU
  Route::group(['prefix' => 'menu', 'as' => 'menu-'], function () {
    Route::get('/', [MenuController::class, 'index'])->name('index');
    Route::get('/read', [MenuController::class, 'read'])->name('read');
    Route::get('/select', [MenuController::class, 'select'])->name('select');
    Route::get('/selectChildMenu', [MenuController::class, 'selectChildMenu'])->name('selectChildMenu');
    Route::get('/getChildMenu/{id}', [MenuController::class, 'getChildMenu'])->name('getChildMenu');
    Route::get('/getParentMenu', [MenuController::class, 'getParentMenu'])->name('getParentMenu');
    Route::post('/updatesort', [MenuController::class, 'updatesort'])->name('updatesort');
    Route::post('/updatesortchild', [MenuController::class, 'updatesortchild'])->name('updatesortchild');
    Route::post('/store', [MenuController::class, 'store'])->name('store');
    Route::post('/update', [MenuController::class, 'update'])->name('update');
    Route::post('/delete', [MenuController::class, 'delete'])->name('delete');
  });


  # USER
  Route::group(['prefix' => 'user', 'as' => 'user-'], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/read', [UserController::class, 'read'])->name('read');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::get('/select/memberAndEmployee', [UserController::class, 'memberAndEmployee'])->name('memberAndEmployee');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::get('/userGiveRole/{id}', [UserController::class, 'userGiveRole'])->name('userGiveRole');
    Route::put('/giveRole/{uuid}', [UserController::class, 'giveRole'])->name('giveRole');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    Route::post('/store', [UserController::class, 'store'])->name('store');
  });

  # ROLE
  Route::group(['prefix' => 'accessroles', 'as' => 'accessroles-'], function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('/read', [RoleController::class, 'read'])->name('read');
    Route::get('/select', [RoleController::class, 'select'])->name('select');
    Route::get('/detail/{id}', [RoleController::class, 'detail'])->name('detail');
    Route::post('/store', [RoleController::class, 'store'])->name('store');
    Route::post('/updatePermissions', [RoleController::class, 'updatePermissions'])->name('updatePermissions');
    Route::get('/testingGivePermission', [RoleController::class, 'testingGivePermission']);
  });

  # PERMISSION
  Route::group(['prefix' => 'accessPermission', 'as' => 'accessPermission-'], function () {
    Route::get('/', [AccessPermissionController::class, 'index'])->name('index');
    Route::get('/read', [AccessPermissionController::class, 'read'])->name('read');
    Route::post('/store', [AccessPermissionController::class, 'store'])->name('store');
    Route::post('/update', [AccessPermissionController::class, 'update'])->name('update');
    Route::post('/delete', [AccessPermissionController::class, 'delete']);
  });

  /**
   * Profile
   */
  Route::group(['prefix' => 'profile', 'as' => 'profile-'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::get('/read-editor-books', [ProfileController::class, 'readEditorBooks'])
      ->name('readEditorBooks');
  });

  /**
   * MY APP
   * @example http://127.0.0.1:8000/admin/myapp
   */
  Route::group(['prefix' => 'myapp', 'as' => 'myapp-'], function () {
    Route::get('/', [MyAppController::class, 'index']);
    Route::post('/', [MyAppController::class, 'store'])->name('store');
  });

  /**
   * Employee
   */
  Route::group(['prefix' => 'employee', 'as' => 'employee-'], function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/data', [EmployeeController::class, 'data'])->name('data');
    Route::get('/create', [EmployeeController::class, 'create'])->name('create');
    Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('edit');
    Route::get('/{employee}', [EmployeeController::class, 'detail'])->name('detail');
    Route::POST('/', [EmployeeController::class, 'store'])->name('store');
    Route::PUT('/update/{employee}', [EmployeeController::class, 'update'])->name('update');
  });

  /**
   * User Admin
   * @example
   */
  Route::group(['prefix' => 'useradmin', 'as' => 'useradmin-'], function () {
    Route::get('/', [UserAdminController::class, 'index'])->name('index');
    Route::get('/read', [UserAdminController::class, 'read'])->name('read');
    Route::get('/create', [UserAdminController::class, 'create'])->name('create');
    Route::get('/select', [UserAdminController::class, 'select'])->name('select');
    Route::get('/detail/{admin}', [UserAdminController::class, 'show']);
    Route::get('/edit/{admin}', [UserAdminController::class, 'edit']);
    Route::post('/create', [UserAdminController::class, 'store'])->name('store');
    Route::put('/update/{id}', [UserAdminController::class, 'update'])->name('update');
    Route::put('/updateadmin/{id}', [UserAdminController::class, 'updateadmin'])->name('updateadmin');
    Route::get('/userGiveRole/{id}', [UserAdminController::class, 'userGiveRole'])->name('userGiveRole');
    Route::put('/giveRole/{uuid}', [UserAdminController::class, 'giveRole'])->name('giveRole');
    Route::delete('/delete/{id}', [UserAdminController::class, 'destroy']);
    Route::post('/is-active', [UserAdminController::class, 'is_active']);
    Route::post('/is-suspend', [UserAdminController::class, 'is_suspend']);
  });

  /**
   * Master Work Order
   */
  Route::group(['prefix' => 'workorder', 'as' => 'workorder-'], function () {
    Route::get('/select', [MasterWorkOrderController::class, 'select'])->name('select');
    Route::get('/peryaratan', [MasterWorkOrderController::class, 'peryaratan'])->name('peryaratan');
  });

  /**
   * Request Work Order
   */
  Route::group(['prefix' => 'request-workorder', 'as' => 'requestworkorder-'], function () {
    Route::get('/', [RequestWorkOrderController::class, 'index'])->name('index');
    Route::get('/create', [RequestWorkOrderController::class, 'create'])->name('create');
    Route::get('/data', [RequestWorkOrderController::class, 'data'])->name('data');
    Route::post('/store', [RequestWorkOrderController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [RequestWorkOrderController::class, 'edit'])->name('edit');
    Route::get('/detail/{id}', [RequestWorkOrderController::class, 'detail'])->name('detail');
    Route::put('/update/{id}', [RequestWorkOrderController::class, 'update'])->name('update');
    Route::post('/update-workorder-attachment', [RequestWorkOrderController::class, 'updateWorkOrderAttachment'])->name('updateWorkOrderAttachment');
    Route::delete('/delete/{id}', [RequestWorkOrderController::class, 'delete'])->name('delete');
  });

  /**
   * Access Role
   */
  Route::group(['prefix' => 'accessroles', 'as' => 'accessroles-'], function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('/read', [RoleController::class, 'read'])->name('read');
    Route::get('/select', [RoleController::class, 'select'])->name('select');
    Route::get('/detail/{id}', [RoleController::class, 'detail'])->name('detail');
    Route::post('/store', [RoleController::class, 'store'])->name('store');
    Route::post('/updatePermissions', [RoleController::class, 'updatePermissions'])->name('updatePermissions');
    Route::get('/testingGivePermission', [RoleController::class, 'testingGivePermission']);
  });

  /**
   * Work Order
   */
  Route::group(['prefix' => 'work-order', 'as' => 'workorder-'], function () {
    Route::get('/', [WorkOrderController::class, 'index'])->name('index');
    Route::get('/data', [WorkOrderController::class, 'data'])->name('data');
    Route::post('/assignment', [WorkOrderController::class, 'assignment'])->name('assignment');
    Route::post('/assignment-done', [WorkOrderController::class, 'assignmentDone'])->name('assignmentDone');
    Route::get('/detail/{id}', [WorkOrderController::class, 'detail'])->name('detail');
    Route::get('/form/{id}', [WorkOrderController::class, 'form'])->name('form');
  });

  /**
   * Balik Nama Waris
   */
  Route::group(['prefix' => 'balik-nama-waris', 'as' => 'baliknamawaris-'], function () {
    Route::get('/', [BalikNamaWarisController::class, 'index'])->name('index');
    Route::post('/store', [BalikNamaWarisController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [BalikNamaWarisController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [BalikNamaWarisController::class, 'form']);
  });

  /**
   * Pendirian PT
   */
  Route::group(['prefix' => 'pendirian-pt', 'as' => 'pendirianpt-'], function () {
    Route::get('/', [PendirianPTController::class, 'index'])->name('index');
    Route::post('/store', [PendirianPTController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PendirianPTController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PendirianPTController::class, 'form']);
  });

  /**
   * Balik nama jaul beli
   */
  Route::group(['prefix' => 'balik-nama-jual-beli', 'as' => 'baliknamajualbeli-'], function () {
    Route::get('/', [BalikNamaJualBeliController::class, 'index'])->name('index');
    Route::post('/store', [BalikNamaJualBeliController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [BalikNamaJualBeliController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [BalikNamaJualBeliController::class, 'form']);
  });

  /**
   * Balik Nama Hibah
   */
  Route::group(['prefix' => 'balik-nama-hibah', 'as' => 'baliknamahibah-'], function () {
    Route::get('/', [BalikNamaHibahController::class, 'index'])->name('index');
    Route::post('/store', [BalikNamaHibahController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [BalikNamaHibahController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [BalikNamaHibahController::class, 'form']);
  });

  /**
   * Pemecah Sertifikat
   */
  Route::group(['prefix' => 'pemecah-sertifikat', 'as' => 'pemecahsertifikat-'], function () {
    Route::get('/', [PemecahSertifikatController::class, 'index'])->name('index');
    Route::post('/store', [PemecahSertifikatController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PemecahSertifikatController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PemecahSertifikatController::class, 'form']);
  });

  /**
   * Balik APHB
   */
  Route::group(['prefix' => 'balik-aphb', 'as' => 'balikaphb-'], function () {
    Route::get('/', [BalikAPHBController::class, 'index'])->name('index');
    Route::post('/store', [BalikAPHBController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [BalikAPHBController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [BalikAPHBController::class, 'form']);
  });

  /**
   * Balik nama sertifikat
   */
  Route::group(['prefix' => 'balik-nama-sertifikat', 'as' => 'baliknamasertifikat-'], function () {
    Route::get('/', [BalikNamaSertifikatController::class, 'index'])->name('index');
    Route::post('/store', [BalikNamaSertifikatController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [BalikNamaSertifikatController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [BalikNamaSertifikatController::class, 'form']);
  });
});
