<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use stdClass;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {

    if (!Schema::hasTable('menus')) {
      return;
    }

    $verticalMenuJson = file_get_contents(base_path('resources/menu/horizontalMenu.json'));
    $verticalMenuData = json_decode($verticalMenuJson);
    $horizontalMenuJson = file_get_contents(base_path('resources/menu/horizontalMenu.json'));
    $horizontalMenuData = json_decode($horizontalMenuJson);
    $menus = Menu::orderBy('sort', 'ASC')->get();
    $newMenu = new stdClass();
    foreach ($menus as $menu) {
      $row = new stdClass();
      // $row->url = '/admin/' . str_replace('-', '/', $menu->slug);
      $row->url = '/admin/' . $menu->slug;
      $row->name = $menu->name;
      $row->icon = $menu->icon ?? 'ti ti-smart-home';
      $row->slug = $menu->slug;
      $row->is_open = $menu->is_open;

      if ($menu->is_header) {
        $row->menuHeader = $menu->name;
      }

      $subMenus = [];
      foreach ($menu->sub_menu as $sub) {
        $rowSub = new stdClass();
        $rowSub->url = '/admin/' . str_replace('-', '/', $sub->slug);
        $rowSub->name = $sub->name;
        $rowSub->slug = $sub->slug;
        $rowSub->parent_id = $sub->parent_id;
        $subMenus[] = $rowSub;
      }
      $row->is_sub = empty($subMenus) ? false : true;
      $row->submenu = $subMenus;

      $newMenu->menu[] = $row;
    }
    view()->composer('*', function ($view) use ($newMenu, $horizontalMenuData) {
      $view->with('menuData', [$newMenu, $horizontalMenuData]);
    });
  }
}
