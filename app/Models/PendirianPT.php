<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PendirianPT extends Model
{
  use HasFactory;
  protected $table = 'pendirian_p_t_s';
  protected $guarded = ['id'];
  protected $appends = ['view_gambar'];

  protected static function boot(): void
  {
    parent::boot();

    self::creating(function ($model) {});

    self::updating(function ($model) {
      $model->tgl_checklist = $model->checklist ? date('Y-m-d') : null;
    });
  }

  public function getViewGambarAttribute()
  {
    $image = isset($this->attributes['gambar']) ? $this->attributes['gambar'] : false;
    if ($image) {
      return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/general/no-image.jpg');
    }
    return asset('assets/img/general/no-image.jpg');
  }

  /**
   * Get the work_order_assignment that owns the BalikNamaWaris
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function work_order_assignment(): BelongsTo
  {
    return $this->belongsTo(WorkOrderAssignment::class, 'work_order_assignment_id');
  }
}
