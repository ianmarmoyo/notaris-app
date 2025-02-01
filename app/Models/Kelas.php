<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Get the institution that owns the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the semester that owns the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

/**
   * The mapels that belong to the Guru
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function mapels(): BelongsToMany
  {
      return $this->belongsToMany(Mapel::class, 'kelas_mapel', 'kelas_id', 'mapel_id');
  }

  /**
   * The ekskuls that belong to the Kelas
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function ekskuls(): BelongsToMany
  {
      return $this->belongsToMany(Ekstrakulikuler::class, 'kelas_ekskul', 'kelas_id', 'ekskul_id');
  }

  /**
   * The gurus that belong to the Kelas
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function gurus(): BelongsToMany
  {
      return $this->belongsToMany(Guru::class, 'guru_kelas');
  }

  public function wali_kelas()
  {
      return $this->hasOne(Guru::class)->where('jabatan','wali kelas');
  }
}
