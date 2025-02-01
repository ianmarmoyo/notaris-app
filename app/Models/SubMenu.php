<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ["uri"];

    public function getUriAttribute()
    {
        $slug = $this->attributes['slug'];
        return '/' . str_replace('-', '/', $slug);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function access_menu()
    {
        return $this->hasOne(AccessPermissionsMenuGroup::class, 'menu_id')->where('type_menu', 'child');
    }
}
