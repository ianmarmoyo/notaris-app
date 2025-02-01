<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'is_suspend','employee_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Perform pre-authorization checks on the model.
     */
    public function before(Admin $admin, string $ability): bool|null
    {
        if ($admin->hasRole('superadmin')) {
            return true;
        }

        return null; // see the note above in Gate::before about why null must be returned here.
    }

    /**
     * Get the employee that owns the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
