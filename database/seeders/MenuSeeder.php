<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Backtrace\File;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = json_decode(file_get_contents(database_path('datas/menus_parent.json')));
        foreach ($menus as $menu) {
            DB::beginTransaction();
            $menu = Menu::create([
                'name' => $menu->name,
                'icon' => $menu->icon,
                'slug' => $menu->slug,
                'is_header' => $menu->is_header,
                'is_view' => $menu->is_view,
                'sort' => $menu->sort
            ]);
            if (!$menu) {
                DB::rollBack();
            }
            DB::commit();
        }

        $menus_child = json_decode(file_get_contents(database_path('datas/menus_child.json')));
        foreach ($menus_child as $menu) {
            DB::beginTransaction();
            $subMenu = SubMenu::create([
                'parent_id' => $menu->parent_id,
                'name' => $menu->name,
                'icon' => $menu->icon,
                'slug' => $menu->slug,
                'is_view' => $menu->is_view,
                'sort' => $menu->sort
            ]);
            if (!$subMenu) {
                DB::rollBack();
            }
            DB::commit();
        }
    }
}
