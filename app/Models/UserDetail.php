<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function PHPUnit\Framework\returnSelf;

class UserDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = [
        "ViewFotoUser",
        'profileImage'
    ];

    public function scopeLeftJoinUser($query)
    {
        return $query->leftJoin(
            'users',
            'user_details.user_id',
            'users.id'
        );
    }

    public function getViewFotoUserAttribute()
    {
        $image = isset($this->attributes['foto_user']) ? $this->attributes['foto_user'] : false;
        if ($image) {
            return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/general/no-image.jpg');
        }

        return asset('assets/img/general/no-image.jpg');
    }

    public function getProfileImageAttribute()
    {
        $image = isset($this->attributes['foto_user']) ? $this->attributes['foto_user'] : false;
        if ($image) {
            return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/icons/azzia/upload.jpg');
        }

        return asset('assets/img/icons/azzia/upload.jpg');
    }

    /**
     * Get the user that owns the UserDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the tier_affiliate that owns the UserDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tier_affiliate(): BelongsTo
    {
        return $this->belongsTo(TierAffiliate::class, 'tier_affiliate_id');
    }
}
