<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Regencie extends Model
{
    use HasFactory;
    protected $table = 'regencies';
    protected $fillable = ['province_id', 'name'];
    protected $with = ['province'];

    /**
     * Get the Province that owns the Regencie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function scopeLeftJoinProvince($query)
    {
        return $query->leftJoin('provinces', 'provinces.id', '=', 'regencies.province_id');
    }
}
