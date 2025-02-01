<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MyApplication;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use InvalidArgumentException;

class MyAppController extends Controller
{
  function __construct()
  {
    $menu = menu_active("myapp");

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
    $title = __("My Application");
    $data = MyApplication::get();

    $myapp = $data->mapWithKeys(function ($item) {
      return [$item->key => $item->value];
    })->all();
    $myapp = data_set($myapp, 'img_banner_icon', $this->getImageIcon());
    $myapp = data_set($myapp, 'img_banner_login', $this->getImageLogin());
    $myapp = data_set($myapp, 'favicon_icon', $this->getImageFavicon());

    return view('content.myApp.index', compact('title', 'myapp'));
  }

  public function getImageIcon()
  {
    $image = config('configs.img_banner_icon');
    if ($image) {
      return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/general/upload-img.png');
    }
    return asset('assets/img/general/upload-img.png');
  }

  public function getImageLogin()
  {
    $image = config('configs.img_banner_login');
    if ($image) {
      return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/general/upload-img.png');
    }
    return asset('assets/img/general/upload-img.png');
  }

  public function getImageFavicon()
  {
    $image = config('configs.favicon_icon');
    if ($image) {
      return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/general/upload-img.png');
    }
    return asset('assets/img/general/upload-img.png');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $dataText = $request->except('_token', 'img_banner_login', 'img_banner_icon');
    $arrKey = array_keys($dataText);
    $arrValue = array_values($dataText);

    DB::beginTransaction();
    // Insert key
    foreach ($arrKey as $key => $val) {
      $data = ['key' => $arrValue[$key]];
      $storeKey = MyApplication::updateOrCreate([
        'key' => $val,
      ], [
        'key' => $val,
        'value' => $arrValue[$key]
      ]);

      if (!$storeKey) {
        DB::rollBack();
        return response()->json([
          'status' => false,
          'message' => $storeKey,
        ], 400);
      }
    }

    if ($request->hasFile('img_banner_icon')) {
      $this->checkImgIcon();
      $this->storeImgaeBannerIcon(
        $request->file('img_banner_icon')
      );
    }

    if ($request->hasFile('img_banner_login')) {
      $this->checkImgLogin();
      $this->storeImgaeBannerLogin(
        $request->file('img_banner_login')
      );
    }

    if ($request->hasFile('favicon_icon')) {
      $this->checkImgFavicon();
      $this->storeImgaeFavicon(
        $request->file('favicon_icon')
      );
    }

    DB::commit();
    return response()->json([
      'status' => true,
      'message' => 'Success',
    ], 200);
  }

  public function checkImgIcon()
  {
    $img = MyApplication::where('key', 'img_banner_icon')->first();

    if ($img) {
      if (Storage::exists($img->value)) {
        Storage::delete($img->value);
      }
      $img->delete();
    }

    return true;
  }

  public function checkImgLogin()
  {
    $img = MyApplication::where('key', 'img_banner_login')->first();

    if ($img) {
      if (Storage::exists($img->value)) {
        Storage::delete($img->value);
      }
      $img->delete();
    }

    return true;
  }

  public function checkImgFavicon()
  {
    $img = MyApplication::where('key', 'favicon_icon')->first();

    if ($img) {
      if (Storage::exists($img->value)) {
        Storage::delete($img->value);
      }
      $img->delete();
    }

    return true;
  }

  public function storeImgaeBannerLogin($img_banner_login)
  {
    $path = "images/myapp";
    $storeImage = new MyApplication();

    // Store Image Banner Login
    $fileNameBannerLogin = str_replace(' ', '-', $img_banner_login->getClientOriginalName());
    $storageBannerLogin = Storage::putFileAs($path, $img_banner_login, $fileNameBannerLogin);

    $storeImage->key = 'img_banner_login';
    $storeImage->value = $storageBannerLogin;
    $storeImage->save();

    return true;
  }

  public function storeImgaeFavicon($img_banner_login)
  {
    $path = "images/myapp";
    $myapp = new MyApplication();

    // Store Image Banner Login
    $file_name = str_replace(' ', '-', $img_banner_login->getClientOriginalName());
    $storeImage = Storage::putFileAs($path, $img_banner_login, $file_name);

    $myapp->key = 'favicon_icon';
    $myapp->value = $storeImage;
    $myapp->save();

    return true;
  }

  public function storeImgaeBannerIcon($img_banner_icon)
  {
    $path = "images/myapp";

    // Store Image Banner Icon
    $fileNameBannerIcon = str_replace(' ', '-', $img_banner_icon->getClientOriginalName());
    $storageIcon = Storage::putFileAs($path, $img_banner_icon, $fileNameBannerIcon);

    $storeImage = new MyApplication();
    $storeImage->key = 'img_banner_icon';
    $storeImage->value = $storageIcon;

    $storeImage->save();

    return true;
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
