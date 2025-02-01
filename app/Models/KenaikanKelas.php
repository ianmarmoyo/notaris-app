<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KenaikanKelas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'kenaikan_kelas';

    /**
     * Get the admin that owns the KenaikanKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Get the institution that owns the KenaikanKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the kelas_lama that owns the KenaikanKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas_lama(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'dari_kelas_id');
    }

    /**
     * Get the kelas_baru that owns the KenaikanKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas_baru(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'ke_kelas_id');
    }
}
