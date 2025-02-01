<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BankSoal extends Model
{
  use HasFactory;
  protected $guarded = [];
  protected $with = ['tipe_soal', 'user_admin', 'institution', 'kelas', 'mapel'];
  protected $appends = [
    "document",
  ];

  protected static function boot(): void
  {
    parent::boot();

    self::creating(function ($model) {
      $model->admin_id = auth()->user()->id;
    });
  }

  public function getDocumentAttribute()
  {
    $image = isset($this->attributes['document_path']) ? $this->attributes['document_path'] : false;
    if ($image) {
      return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/general/document-not-found.png');
    }
    return asset('assets/img/general/document-not-found.png');
  }

  /**
   * Get the tipe_soal that owns the BankSoal
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function tipe_soal(): BelongsTo
  {
    return $this->belongsTo(TipeSoal::class, 'tipe_soal_id',);
  }

  /**
   * Get the user_admin that owns the BankSoal
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user_admin(): BelongsTo
  {
    return $this->belongsTo(Admin::class, 'admin_id');
  }

  /**
   * Get the institution that owns the BankSoal
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function institution(): BelongsTo
  {
    return $this->belongsTo(Institution::class);
  }

  /**
   * Get the kelas that owns the BankSoal
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function kelas(): BelongsTo
  {
    return $this->belongsTo(Kelas::class);
  }

  /**
   * Get the mapel that owns the BankSoal
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function mapel(): BelongsTo
  {
    return $this->belongsTo(Mapel::class, 'mapel_id');
  }
}
