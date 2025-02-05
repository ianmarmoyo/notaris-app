<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  /**
   * Get all of the work_orders for the Client
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function work_orders(): HasMany
  {
    return $this->hasMany(WorkOrder::class);
  }
}
