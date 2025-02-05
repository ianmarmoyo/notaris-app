<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WorkOrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

  public function setHargaAttribute($value)
  {
    $replace = str_replace([',', '.', ' '], '', $value);
    $this->attributes['harga'] = str_replace('Rp', '', $replace);
  }

  /**
   * Get the master_work_order that owns the WorkOrderDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function master_work_order(): BelongsTo
  {
      return $this->belongsTo(MasterWorkOrder::class, 'master_work_order_id');
  }

  /**
   * Get all of the work_order_attachments for the WorkOrderDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function work_order_attachments(): HasMany
  {
      return $this->hasMany(WorkOrderAttachment::class);
  }

  /**
   * Get the work_order that owns the WorkOrderDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function work_order(): BelongsTo
  {
      return $this->belongsTo(WorkOrder::class);
  }

  /**
   * Get the work_order_assignment associated with the WorkOrderDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function work_order_assignment(): HasOne
  {
    return $this->hasOne(WorkOrderAssignment::class, 'work_order_detail_id');
  }
}
