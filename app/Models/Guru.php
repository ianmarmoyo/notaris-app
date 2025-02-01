<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Guru extends Model
{
  use HasFactory;
  protected $guarded = [];

  protected $appends = [
    "view_foto",
  ];

  public function getViewFotoAttribute()
  {
    $image = isset($this->attributes['foto']) ? $this->attributes['foto'] : false;
    if ($image) {
      return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/general/no-image.jpg');
    }
    return asset('assets/img/general/no-image.jpg');
  }

  /**
   * Get the institution that owns the Guru
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function institution(): BelongsTo
  {
    return $this->belongsTo(Institution::class);
  }

  /**
   * The kelases that belong to the Guru
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function kelases(): BelongsToMany
  {
    return $this->belongsToMany(Kelas::class, 'guru_kelas');
  }

  /**
   * Get the kelas that owns the Guru
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function kelas(): BelongsTo
  {
    return $this->belongsTo(Kelas::class);
  }

  /**
   * Get the admin that owns the Guru
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function admin(): BelongsTo
  {
    return $this->belongsTo(Admin::class);
  }

  public function mapelKelas()
  {
    return $this->belongsToMany(Mapel::class, 'guru_mapel_kelas')
      ->withPivot('kelas_id');
  }

  /**
   * The ekskuls that belong to the Guru
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function ekskuls(): BelongsToMany
  {
      return $this->belongsToMany(Ekstrakulikuler::class, 'ekskul_guru', 'guru_id', 'ekskul_id');
  }

  public function getGuruKelas()
  {
    $role_guru = Auth::user()->getRoleNames()->toArray();
    $kelas = [];

    if (in_array('wali kelas', $role_guru)) {
      array_push($kelas, Auth::user()->guru->kelas_id);
    }

    // if (in_array('guru', $role_guru)) {
      foreach (Auth::user()->guru->kelases->pluck('id')->toArray() as $kelas_id) {
        array_push($kelas, $kelas_id);
      }
    // }

    return count($kelas) > 0 ? array_unique($kelas) : false;
  }

  public function riwayatWaliKelas()
  {
    return $this->hasMany(RiwayatGuruWaliKelas::class,'guru_id')->orderBy('created_at', 'desc');
  }
}
