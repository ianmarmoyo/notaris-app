<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruEkskulKelas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'guru_ekskul_kelas';

  public function guru()
  {
    return $this->belongsTo(Guru::class);
  }

  public function ekskul()
  {
    return $this->belongsTo(Ekstrakulikuler::class);
  }

  public function kelas()
  {
    return $this->belongsTo(Kelas::class);
  }
}
