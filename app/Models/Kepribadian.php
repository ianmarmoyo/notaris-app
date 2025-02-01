<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kepribadian extends Model
{
    use HasFactory;
    protected $table = 'kepribadians';
    protected $guarded = ['id'];

  /**
   * The kelases that belong to the Ekstrakulikuler
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function kelases(): BelongsToMany
  {
    return $this->belongsToMany(Kelas::class, 'kelas_kepribadian', 'kepribadian_id', 'kelas_id');
  }
}
