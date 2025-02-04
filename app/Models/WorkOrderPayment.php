<?php

namespace App\Models;

use App\Helpers\SerialNumberHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class WorkOrderPayment extends Model
{
  use HasFactory;
  protected $guarded = [];

  protected static function boot(): void
  {
    parent::boot();
    static::creating(function ($model) {
      $model->user_admin_id = Auth::guard('admin')->user()->id;
      $model->no_pembayaran = $model->generateInvoice();
    });
  }

  public function generateInvoice()
  {
    $tahunSekarang = date("Y");
    $duaDigitTahun = substr($tahunSekarang, -2);
    $formatNo = 'WOP' . $duaDigitTahun . date('md') . '';

    $code = SerialNumberHelper::code(
      'work_order_payments',
      $formatNo,
      'no_pembayaran',
      strlen($formatNo) + 5,
    );
    return $code;
  }

  public function setNominalAttribute($value)
  {
    $replace = str_replace([',', '.', ' '], '', $value);
    $this->attributes['nominal'] = str_replace('Rp', '', $replace);
  }

  /**
   * Get the work_order that owns the WorkOrderPayment
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function work_order(): BelongsTo
  {
    return $this->belongsTo(WorkOrder::class, 'work_order_id');
  }
}
