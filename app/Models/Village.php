<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Village extends Model
{
    use HasFactory;
    protected $fillable = ['district_id', 'name'];
    protected $with = ['district'];

    /**
     * Get the district that owns the Village
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function scopeLeftJoinDistrict($query)
    {
        return $query->leftJoin('districts', 'districts.id', '=', 'villages.district_id');
    }
}
