<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Institution extends Model
{
  use HasFactory;
  protected $guarded = [];
  protected $appends = [
    "view_image",
  ];

  public function getViewImageAttribute()
  {
    $image = isset($this->attributes['img_report_header']) ? $this->attributes['img_report_header'] : false;
    if ($image) {
      return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/general/no-image.jpg');
    }
    return asset('assets/img/general/no-image.jpg');
  }
}
