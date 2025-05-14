<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderAnotherExpense extends Model
{
    use HasFactory;
    protected $guarded = [];

  public function setNominalAttribute($value)
  {
    $replace = str_replace([',', '.', ' '], '', $value);
    $this->attributes['nominal'] = str_replace('Rp', '', $replace);
  }
}
