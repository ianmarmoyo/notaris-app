<?php

use App\Http\Controllers\Admin\AccessPermissionController;
use App\Http\Controllers\Admin\AktaPermohonanHakController;
use App\Http\Controllers\Admin\BalikAPHBController;
use App\Http\Controllers\Admin\BalikNamaHibahController;
use App\Http\Controllers\Admin\BalikNamaJualBeliController;
use App\Http\Controllers\Admin\BalikNamaSertifikatController;
use App\Http\Controllers\Admin\BalikNamaWarisController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\KlienController;
use App\Http\Controllers\Admin\LegalisasiController;
use App\Http\Controllers\Admin\MasterWorkOrderController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MyAppController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PelepasanHakController;
use App\Http\Controllers\Admin\PembubaranKoperasiController;
use App\Http\Controllers\Admin\PemecahSertifikatController;
use App\Http\Controllers\Admin\PendiranPTperoranganController;
use App\Http\Controllers\Admin\PendirianCvController;
use App\Http\Controllers\Admin\PendirianKoperasiController;
use App\Http\Controllers\Admin\PendirianPerkumpulanController;
use App\Http\Controllers\Admin\PendirianPTController;
use App\Http\Controllers\Admin\PendirianYayasanController;
use App\Http\Controllers\Admin\PenggabunganSertifikatController;
use App\Http\Controllers\Admin\PeningkatanHakController;
use App\Http\Controllers\Admin\PenurunanHakController;
use App\Http\Controllers\Admin\PerjanjianLainnyaController;
use App\Http\Controllers\Admin\PerubahanKoperasiController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportFinanceController;
use App\Http\Controllers\Admin\ReportWorkOrderController;
use App\Http\Controllers\Admin\RequestWorkOrderController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SertifikatPermohonanHakController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WarmarkingController;
use App\Http\Controllers\Admin\WorkOrderController;
use App\Http\Controllers\Admin\WorkOrderDeadlineController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';



Route::middleware(
  'auth:admin',
)->group(function () {

  # DASHBOARD
  Route::group(['prefix' => 'dashboard', 'as' => 'dashboard-'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('analytics');
    Route::get('/data-chart-layanan', [DashboardController::class, 'dataChartLayanan'])->name('dataChartLayanan');
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
   * Klien
   */
  Route::group(['prefix' => 'client', 'as' => 'client-'], function () {
    Route::get('/', [KlienController::class, 'index'])->name('index');
    Route::get('/read', [KlienController::class, 'read'])->name('read');
    Route::get('/select', [KlienController::class, 'select'])->name('select');
    Route::get('/detail/{id}', [KlienController::class, 'detail'])->name('detail');
    Route::post('/store', [KlienController::class, 'store'])->name('store');
    Route::post('/update', [KlienController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [KlienController::class, 'delete']);
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
    Route::get('/select', [RequestWorkOrderController::class, 'select'])->name('select');
    Route::post('/store', [RequestWorkOrderController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [RequestWorkOrderController::class, 'edit'])->name('edit');
    Route::get('/detail/{id}', [RequestWorkOrderController::class, 'detail'])->name('detail');
    Route::put('/update/{id}', [RequestWorkOrderController::class, 'update'])->name('update');
    Route::post('/update-workorder-attachment', [RequestWorkOrderController::class, 'updateWorkOrderAttachment'])->name('updateWorkOrderAttachment');
    Route::PUT('/update-workorder-detail/{work_order_detail_id}', [RequestWorkOrderController::class, 'updateWorkOrderDetail'])->name('updateWorkOrderDetail');
    Route::delete('/delete/{id}', [RequestWorkOrderController::class, 'delete'])->name('delete');
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

  /**
   * Payment
   */
  Route::group(['prefix' => 'payment', 'as' => 'payment-'], function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::get('/data', [PaymentController::class, 'data'])->name('data');
    Route::get('/select-request-work-order', [PaymentController::class, 'selectRequestWorkOrder'])->name('selectRequestWorkOrder');
    Route::get('/create', [PaymentController::class, 'create'])->name('create');
    Route::get('/detail/{id}', [PaymentController::class, 'detail'])->name('detail');
    Route::post('/store', [PaymentController::class, 'store'])->name('store');
    Route::get('/get-workorder-payment', [PaymentController::class, 'getworkorderpayment'])->name('getworkorderpayment');
    Route::post('/delete', [PaymentController::class, 'delete']);
  });

  /**
   * Laporan Keuangan
   */
  Route::group(['prefix' => 'reportfinance', 'as' => 'reportfinance-'], function () {
    Route::get('/', [ReportFinanceController::class, 'index'])->name('index');
    Route::get('/data', [ReportFinanceController::class, 'data'])->name('data');
  });

  /**
   * Laporan Work Order
   */
  Route::group(['prefix' => 'reportworkorder', 'as' => 'reportworkorder-'], function () {
    Route::get('/', [ReportWorkOrderController::class, 'index'])->name('index');
    Route::get('/data', [ReportWorkOrderController::class, 'data'])->name('data');
  });

  /**
   * Peningkatan HAK
   */
  Route::group(['prefix' => 'peningkatan-hak', 'as' => 'peningkatanhak-'], function () {
    Route::get('/', [PeningkatanHakController::class, 'index'])->name('index');
    Route::post('/store', [PeningkatanHakController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PeningkatanHakController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PeningkatanHakController::class, 'form']);
  });

  /**
   * Penurunan HAK
   */
  Route::group(['prefix' => 'penurunan-hak', 'as' => 'penurunanhak-'], function () {
    Route::get('/', [PenurunanHakController::class, 'index'])->name('index');
    Route::post('/store', [PenurunanHakController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PenurunanHakController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PenurunanHakController::class, 'form']);
  });

  /**
   * Penggabungan Sertifikat
   */
  Route::group(['prefix' => 'penggabungan-sertifikat', 'as' => 'penggabungansertifikat-'], function () {
    Route::get('/', [PenggabunganSertifikatController::class, 'index'])->name('index');
    Route::post('/store', [PenggabunganSertifikatController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PenggabunganSertifikatController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PenggabunganSertifikatController::class, 'form']);
  });

  /**
   * pelepasan-hak
   */
  Route::group(['prefix' => 'pelepasan-hak', 'as' => 'pelepasanhak-'], function () {
    Route::get('/', [PelepasanHakController::class, 'index'])->name('index');
    Route::post('/store', [PelepasanHakController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PelepasanHakController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PelepasanHakController::class, 'form']);
  });

  /**
   * Akta Permohonan Hak
   */
  Route::group(['prefix' => 'akta-permohonan-hak', 'as' => 'aktapermohonanhak-'], function () {
    Route::get('/', [AktaPermohonanHakController::class, 'index'])->name('index');
    Route::post('/store', [AktaPermohonanHakController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [AktaPermohonanHakController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [AktaPermohonanHakController::class, 'form']);
  });

  /**
   * sertifikat-permohonan-hak
   */
  Route::group(['prefix' => 'sertifikat-permohonan-hak', 'as' => 'sertifikatpermohonanhak-'], function () {
    Route::get('/', [SertifikatPermohonanHakController::class, 'index'])->name('index');
    Route::post('/store', [SertifikatPermohonanHakController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [SertifikatPermohonanHakController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [SertifikatPermohonanHakController::class, 'form']);
  });

  /**
   * sertifikat-permohonan-hak
   */
  Route::group(['prefix' => 'pendirian-pt-perorangan', 'as' => 'pendirianptperorangan-'], function () {
    Route::get('/', [PendiranPTperoranganController::class, 'index'])->name('index');
    Route::post('/store', [PendiranPTperoranganController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PendiranPTperoranganController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PendiranPTperoranganController::class, 'form']);
  });

  /**
   * Pendiran CV
   */
  Route::group(['prefix' => 'pendirian-cv', 'as' => 'pendiriancv-'], function () {
    Route::get('/', [PendirianCvController::class, 'index'])->name('index');
    Route::post('/store', [PendirianCvController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PendirianCvController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PendirianCvController::class, 'form']);
  });

  /**
   * pendirian-perkumpulan
   */
  Route::group(['prefix' => 'pendirian-perkumpulan', 'as' => 'pendirianperkumpulan-'], function () {
    Route::get('/', [PendirianPerkumpulanController::class, 'index'])->name('index');
    Route::post('/store', [PendirianPerkumpulanController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PendirianPerkumpulanController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PendirianPerkumpulanController::class, 'form']);
  });

  /**
   * Legalisasi
   */
  Route::group(['prefix' => 'legalisasi', 'as' => 'legalisasi-'], function () {
    Route::get('/', [LegalisasiController::class, 'index'])->name('index');
    Route::post('/store', [LegalisasiController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [LegalisasiController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [LegalisasiController::class, 'form']);
  });

  /**
   * Warmarking
   */
  Route::group(['prefix' => 'warmarking', 'as' => 'warmarking-'], function () {
    Route::get('/', [WarmarkingController::class, 'index'])->name('index');
    Route::post('/store', [WarmarkingController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [WarmarkingController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [WarmarkingController::class, 'form']);
  });

  /**
   * Perjanjian lainnya
   */
  Route::group(['prefix' => 'perjanjian-lainnya', 'as' => 'perjanjianlainnya-'], function () {
    Route::get('/', [PerjanjianLainnyaController::class, 'index'])->name('index');
    Route::post('/store', [PerjanjianLainnyaController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PerjanjianLainnyaController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PerjanjianLainnyaController::class, 'form']);
  });

  /**
   * Pendirian Yayasan
   */
  Route::group(['prefix' => 'pendirian-yayasan', 'as' => 'pendirianyayasan-'], function () {
    Route::get('/', [PendirianYayasanController::class, 'index'])->name('index');
    Route::post('/store', [PendirianYayasanController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PendirianYayasanController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PendirianYayasanController::class, 'form']);
  });

  /**
   * Pendirian koperasi
   */
  Route::group(['prefix' => 'pendirian-koperasi', 'as' => 'pendiriankoperasi-'], function () {
    Route::get('/', [PendirianKoperasiController::class, 'index'])->name('index');
    Route::post('/store', [PendirianKoperasiController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PendirianKoperasiController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PendirianKoperasiController::class, 'form']);
  });

  /**
   * Perubahan koperasi
   */
  Route::group(['prefix' => 'perubahan-koperasi', 'as' => 'perubahankoperasi-'], function () {
    Route::get('/', [PerubahanKoperasiController::class, 'index'])->name('index');
    Route::post('/store', [PerubahanKoperasiController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PerubahanKoperasiController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PerubahanKoperasiController::class, 'form']);
  });

  /**
   * Pembubaran koperasi
   */
  Route::group(['prefix' => 'pembubaran-koperasi', 'as' => 'pembubarankoperasi-'], function () {
    Route::get('/', [PembubaranKoperasiController::class, 'index'])->name('index');
    Route::post('/store', [PembubaranKoperasiController::class, 'store'])->name('store');
    Route::get('/work-order-assignment/{work_order_assignment_id}', [PembubaranKoperasiController::class, 'detail']);
    Route::get('/work-order-assignment/{work_order_assignment_id}/form', [PembubaranKoperasiController::class, 'form']);
  });

  /**
   * Work Order Deadline
   */
  Route::group(['prefix' => 'workorderdeadline', 'as' => 'workorderdeadline-'], function () {
    Route::get('/', [WorkOrderDeadlineController::class, 'index'])->name('index');
    Route::post('/store', [WorkOrderDeadlineController::class, 'store'])->name('store');
  });
});
