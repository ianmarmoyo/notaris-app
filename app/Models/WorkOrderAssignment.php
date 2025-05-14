<?php

namespace App\Models;

use App\Enums\StatusAssignmentEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderAssignment extends Model
{
    use HasFactory;
  protected $guarded = [];
  protected $with = ['work_order_another_expenses'];
  protected $appends = [
    'work_order_late',
  ];

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

  public function getWorkOrderLateAttribute()
  {
    if ($this->status_penugasan == StatusAssignmentEnum::ON_PROCESS) {
      $tgl_jatuh_tempo_end = Carbon::parse($this->tgl_jatuh_tempo)->startOfDay();

      $loan_date = Carbon::parse(now()->endOfDay());
      $tgl_jatuh_tempo = Carbon::parse($tgl_jatuh_tempo_end);
      $diff = $loan_date->diffInDays($tgl_jatuh_tempo);
      if (now()->endOfDay()->greaterThan($tgl_jatuh_tempo)) {
        $diffInDays = $tgl_jatuh_tempo->diffInDays(now()->endOfDay());
        return $diffInDays > 0 ? "Terlambat {$diffInDays} hari" : 'Sisa hari ini';
      } else {
        $loan_date = Carbon::parse(now()->startOfDay());
        $tgl_jatuh_tempo_end = Carbon::parse($this->tgl_jatuh_tempo)->endOfDay();
        $diffInDays = $loan_date->diffInDays($tgl_jatuh_tempo);
        return "Sisa {$diffInDays} hari";
      }
    } else {
      $tgl_jatuh_tempo = Carbon::parse($this->tgl_jatuh_tempo)->startOfDay();
      $return_date = Carbon::parse($this->tgl_selesai)->endOfDay();

      if ($return_date->greaterThan($tgl_jatuh_tempo)) {
        $diff = $return_date->diffInDays($tgl_jatuh_tempo);
        return "Terlambat {$diff} hari";
      } else {
        return '';
      }
    }
  }

  public function work_order_another_expenses()
  {
    return $this->hasMany(WorkOrderAnotherExpense::class, 'work_order_assignment_id');
  }
}
