<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatGuruWaliKelas extends Model
{
    use HasFactory;
    protected $table = 'riwayat_guru_wali_kelas';
    protected $guarded = ['id'];

    /**
     * Get the kelas that owns the RiwayatGuruWaliKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
