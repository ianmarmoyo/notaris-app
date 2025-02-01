<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ekstrakulikuler extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  /**
   * The gurus that belong to the Ekstrakulikuler
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function gurus(): BelongsToMany
  {
    return $this->belongsToMany(Guru::class, 'ekskul_guru', 'ekskul_id', 'guru_id');
  }

  /**
   * The kelases that belong to the Ekstrakulikuler
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function kelases(): BelongsToMany
  {
    return $this->belongsToMany(Kelas::class, 'kelas_ekskul', 'ekskul_id', 'kelas_id');
  }
}
