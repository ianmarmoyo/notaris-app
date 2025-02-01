<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public $sort;

    function __construct()
    {
        $menu = menu_active("menu");

        if (isset($menu->menu)) {
            View::share('menu_active', $menu->slug);
            View::share('menu_open', $menu->menu->slug);
        } else {
            View::share('menu_active', $menu);
        }
    }

    function setSort($sort)
    {
        $this->sort = $sort;
    }

    function getSort()
    {
        return $this->sort;
    }

    public function index()
    {
        $title = "Menu";
        $menusParent = Menu::orderBy('sort', 'ASC')->get();

        return view('content.menu.index', compact('title', 'menusParent'));
    }

    public function read(Request $request)
    {
        $start = $request->start;
        $length = $request->length;
        $query = $request->search['value'];
        $sort = $request->columns[$request->order[0]['column']]['data'];
        $dir = $request->order[0]['dir'];
        $search = $request->search['value'];

        $query = Menu::select('id');
        $query->where(function ($q) use ($search) {
            $q->whereRaw("(
                UPPER(name) like '%" . $search . "%'
                or
                UPPER(slug) like '%" . $search . "%')
            ");
        });
        $totals = $query->count();

        $query = Menu::select('menus.*');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("(
                    UPPER(name) like '%" . $search . "%'
                    or
                    UPPER(slug) like '%" . $search . "%')
                ");
            });
        }
        $query->offset($start);
        $query->limit($length);
        $query->orderBy('sort', "ASC");
        $menus = $query->get();

        $data = [];
        foreach ($menus as $menu) {
            $menu->no = ++$start;
            $icon = $menu->icon == null ? 'ti ti-smart-home' : $menu->icon;
            $menu->icon = 'menu-icon tf-icons ' . $icon;
            $menu->_icon = $icon;
            $data[] = $menu;
        }
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totals,
            'recordsFiltered' => $totals,
            'data' => $data
        ], 200);
    }

    public function updatesort(Request $request)
    {
        $order = json_decode($request->order);
        $sort = 1;
        foreach ($order as $order => $parent) {
            $menu = Menu::find($parent->id);
            $menu->sort = $sort++;
            $menu->save();
        }

        return response()->json([
            'status'   => true,
            'message' => 'Success Update Data'
        ], 200);
    }

    public function updatesortchild(Request $request)
    {
        $order = json_decode($request->order);
        $sort = 1;
        foreach ($order as $order => $subMenu) {
            $menu = SubMenu::find($subMenu->id);
            $menu->sort = $sort++;
            $menu->save();
        }

        return response()->json([
            'status'   => true,
            'message' => 'Success Update Data'
        ], 200);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        // * Single Menu
        if (!$request->menu_header && !$request->is_header) {
            $menu = Menu::create([
                'name' => $request->menu_name,
                'icon' => $request->menu_icon,
                'slug' => Str::slug($request->slug),
                'is_header' => isset($request->is_header) ?? 0,
                'is_view' => 0,
                'sort' => 0
            ]);
            if (!$menu) {
                DB::rollBack();
                return response()->json([
                    'status'     => false,
                    'message'     => $menu
                ], 400);
            }
        }

        // * Sub Menu
        if ($request->menu_header) {
            $subMenu = SubMenu::create([
                'parent_id' => $request->menu_header ?? null,
                'name' => $request->menu_name,
                'icon' => $request->menu_icon,
                'slug' => Str::slug($request->slug),
                'is_view' => 0
            ]);

            if (!$subMenu) {
                DB::rollBack();
                return response()->json([
                    'status'     => false,
                    'message'     => $subMenu
                ], 400);
            }
        }

        // * Title Menu
        if ($request->is_header) {
            $titleMenu = Menu::create([
                'name' => $request->menu_name,
                'is_view' => 1,
                'is_header' => 1
            ]);

            if (!$titleMenu) {
                DB::rollBack();
                return response()->json([
                    'status'     => false,
                    'message'     => $titleMenu
                ], 400);
            }
        }

        DB::commit();
        return response()->json([
            'status'     => true,
            'message'     => 'Success'
        ], 200);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $is_parent = $request->is_parent == 'true' ? true : false;
        if ($is_parent) {
            $menu = Menu::find($id);
            $menu->update([
                'name' => $request->menu_name,
                'icon' => $request->menu_icon,
                'slug' => $request->slug
            ]);
        } else {
            $subMenu = SubMenu::find($id);
            $subMenu->update([
                'name' => $request->menu_name,
                'slug' => $request->slug
            ]);
        }

        return response()->json([
            'status'     => true,
            'message'     => 'Success'
        ], 200);
    }

    public function select(Request $request)
    {
        $start = $request->page ? $request->page - 1 : 0;
        $length = $request->limit;
        $name = strtoupper($request->name) ?? '';
        $regency_id = $request->regency_id ?? 0;

        //Count Data
        $query = Menu::whereRaw("upper(name) like '%$name%'");
        $query->where('is_header', 0);
        $recordsTotal = $query->count();

        //Select Pagination
        $query = Menu::whereRaw("upper(name) like '%$name%'");
        $query->where('is_header', 0);
        $query->offset($start * $length);
        $query->limit($length);
        $query->orderBy('sort', "ASC");
        $menus = $query->get();

        return response()->json([
            'recorsTotal' => $recordsTotal,
            'data' => $menus
        ], 200);
    }

    public function selectChildMenu(Request $request)
    {
        $start = $request->page ? $request->page - 1 : 0;
        $length = $request->limit;
        $name = strtoupper($request->name) ?? '';

        //Count Data
        $query = SubMenu::whereRaw("upper(name) like '%$name%'");
        $recordsTotal = $query->count();

        //Select Pagination
        $query = SubMenu::whereRaw("upper(name) like '%$name%'");
        $query->offset($start * $length);
        $query->limit($length);
        $query->orderBy('sort', "ASC");
        $menus = $query->get();

        return response()->json([
            'recorsTotal' => $recordsTotal,
            'data' => $menus
        ], 200);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        if ($request->is_parent < 1) {
            $menu = Menu::find($id);

            if (count($menu->sub_menu) > 0) {
                return response()->json([
                    'status'     => false,
                    'message'     => 'Menu parent tidak dapat dihapus.'
                ], 400);
            }

            $menu->delete();
            return response()->json([
                'status'     => true,
                'message'     => 'Success'
            ], 200);
        } else {
            $subMenu = SubMenu::find($id);
            $subMenu->delete();
        }

        return response()->json([
            'status'     => true,
            'message'     => 'Success'
        ], 200);
    }

    public function getParentMenu()
    {
        $parent_menu = Menu::orderBy('sort', 'ASC')->get();

        if (!$parent_menu) {
            return response()->json([
                'status' => false,
                'data' => ''
            ], 400);
        }
        return response()->json([
            'status' => true,
            'data' => $parent_menu
        ], 200);
    }

    public function getChildMenu($id)
    {
        $child_menu = SubMenu::where('parent_id', $id)->orderBy('sort', 'ASC')->get();

        if (!$child_menu) {
            return response()->json([
                'status' => false,
                'data' => ''
            ], 400);
        }
        return response()->json([
            'status' => true,
            'data' => $child_menu
        ], 200);
    }
}
