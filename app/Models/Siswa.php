<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Siswa extends Model
{
  use HasFactory;
  protected $guarded = [];
  /**
   * Get the institution that owns the Siswa
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function institution(): BelongsTo
  {
    return $this->belongsTo(Institution::class);
  }

  /**
   * Get the kelas that owns the Siswa
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function kelas(): BelongsTo
  {
    return $this->belongsTo(Kelas::class, 'kelas_id');
  }

  /**
   * Get all of the riwayat_kelas for the Siswa
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function riwayat_kelas(): HasMany
  {
    return $this->hasMany(RiwayatKelas::class)->orderBy('id', 'desc');
  }
}
