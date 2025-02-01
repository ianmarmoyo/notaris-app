<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatKelas extends Model
{
    use HasFactory;
  protected $guarded = [];

  /**
   * Get the kelas that owns the RiwayatKelas
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function kelas(): BelongsTo
  {
      return $this->belongsTo(Kelas::class);
  }

  /**
   * Get the siswa that owns the RiwayatKelas
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function siswa(): BelongsTo
  {
      return $this->belongsTo(Siswa::class, 'siswa_id');
  }
}
