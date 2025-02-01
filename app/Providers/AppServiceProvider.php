<?php

namespace App\Providers;

use App\Models\CartOrder;
use App\Models\OtpCode;
use App\Observers\Otp;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {

  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    $this->app->bind('path.public', function () {
      // return __DIR__ ;
      return base_path() . '/../public_html/koperasibmt';
    });
    view()->composer('frontend.*', function ($view) {

      $auth_user = Auth::guard('web')->user()->id ?? false;
      $link_wa = config('configs.whatsapp_url');

      $view->with('link_wa', $link_wa);
    });

    Paginator::defaultView('vendor.pagination.bootstrap-5');
    config(['app.locale' => 'id']);
    \Carbon\Carbon::setLocale('id');
  }
}
