<?php

namespace App\Models;

use App\Models\Models\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class AccessPermissionsMenuGroup extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['permission'];

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
