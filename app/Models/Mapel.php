<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mapel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function parent()
    {
        return $this->hasOne(Mapel::class, 'id', 'parent_id');
    }

  public function subcategories()
  {

    return $this->hasMany(Mapel::class, 'parent_id');
  }
  /**
   * The kelases that belong to the Mapel
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function kelases(): BelongsToMany
  {
      return $this->belongsToMany(Kelas::class, 'kelas_mapel', 'mapel_id', 'kelas_id');
  }
}
