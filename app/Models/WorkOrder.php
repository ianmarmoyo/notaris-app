<?php

namespace App\Models;

use App\Helpers\SerialNumberHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class WorkOrder extends Model
{
  use HasFactory;
  protected $guarded = [];
  protected $with = ['client'];

  protected static function boot(): void
  {
    parent::boot();

    self::creating(function ($model) {
      $model->created_user = Auth::guard('admin')->user()->id;
      $model->no_wo = $model->generateInvoice();
    });
  }

  public function generateInvoice()
  {
    $tahunSekarang = date("Y");
    $duaDigitTahun = substr($tahunSekarang, -2);
    $formatNo = 'INV' . $duaDigitTahun . date('md') . '';

    $code = SerialNumberHelper::code(
      'work_orders',
      $formatNo,
      'no_wo',
      strlen($formatNo) + 5,
    );
    return $code;
  }

  /**
   * Get the admin that owns the WorkOrder
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function admin(): BelongsTo
  {
    return $this->belongsTo(Admin::class, 'created_user');
  }

  /**
   * Get all of the work_order_details for the WorkOrder
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function work_order_details(): HasMany
  {
    return $this->hasMany(WorkOrderDetail::class);
  }

  /**
   * Get all of the work_order_payments for the WorkOrderPayment
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function work_order_payments(): HasMany
  {
    return $this->hasMany(WorkOrderPayment::class, 'work_order_id');
  }

  /**
   * Get the client that owns the WorkOrder
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }
}
