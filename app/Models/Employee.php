<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];
  protected $appends = [
    "view_foto",
  ];

  public function getViewFotoAttribute()
  {
    $image = isset($this->attributes['foto']) ? $this->attributes['foto'] : false;
    if ($image) {
      return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/general/no-image.jpg');
    }
    return asset('assets/img/general/no-image.jpg');
  }

  /**
   * Get the admin associated with the Employee
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function admin(): HasOne
  {
      return $this->hasOne(Admin::class, 'employee_id');
  }
}
