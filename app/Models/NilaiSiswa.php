<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSiswa extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  protected static function boot(): void
  {
    parent::boot();

    self::creating(function ($model) {
      $model->created_user = auth()->user()->id;
    });

    self::updating(function ($model) {
      $model->updated_user = auth()->user()->id;
    });
  }
}
