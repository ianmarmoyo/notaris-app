<?php

namespace App\Models;

use App\Models\AccessPermissionsMenuGroup;
use App\Models\SubMenu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
  protected $guarded = [];
  protected $with = ['sub_menu'];
  protected $appends = ["uri"];

  public function sub_menu()
  {
    return $this->hasMany(SubMenu::class, 'parent_id')->orderBy('sort', 'ASC');
  }

  public function getUriAttribute()
  {
    $slug = $this->attributes['slug'];
    // return '/' . str_replace('-', '/', $slug);
    return '/' . $slug;
  }

  public function getNameAttribute()
  {
    if ($this->attributes['is_header']) {
      return Str::upper($this->attributes['name']);
    } else {
      return $this->attributes['name'];
    }
  }

  public function getIsHeaderAttribute($value)
  {
    return (int) $value;
  }

  public function access_menu()
  {
    return $this->hasMany(AccessPermissionsMenuGroup::class, 'menu_id')
      ->where('type_menu', 'parent')->orderBy('id', 'DESC');
  }
}
