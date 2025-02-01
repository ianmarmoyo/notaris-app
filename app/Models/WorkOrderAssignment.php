<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderAssignment extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the work_order_detail that owns the WorkOrderAssignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function work_order_detail(): BelongsTo
    {
        return $this->belongsTo(WorkOrderDetail::class, 'work_order_detail_id');
    }

    /**
     * Get the user_admin that owns the WorkOrderAssignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'user_admin_id');
    }
}
