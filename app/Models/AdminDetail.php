<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class AdminDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['province', 'regency', 'district', 'village'];
    protected $appends = ['full_address', 'profileImage'];


    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regencie::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function getFullAddressAttribute()
    {
        if (isset($this->province->name) && isset($this->regency->name)) {
            return $this->province->name . ' ,' . $this->regency->name . ' ,' . $this->district->name . ' ,' . $this->village->name . ' | ' . $this->attributes['address'];
        }
    }

    /**
     * Get the admin that owns the AdminDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function getPhoto()
    {
        if ($this->photo) {
            return Storage::exists($this->photo) ? url('storage/' . $this->photo) : Storage::get('assets/img/general/no-image.jpg');
        }

        return url('assets/img/general/no-image.jpg');
    }

    public function getProfileImageAttribute()
    {
        $image = isset($this->attributes['photo']) ? $this->attributes['photo'] : false;
        if ($image) {
            return Storage::exists($image) ? url('storage/' . $image) : asset('assets/img/icons/azzia/upload.jpg');
        }

        return asset('assets/img/icons/azzia/upload.jpg');
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_replace(' ', '', $value);
    }
}
