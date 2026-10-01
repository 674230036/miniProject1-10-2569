<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairTicket extends Model
{
    protected $fillable = [
        'ticket_number',
        'customer_id',
        'phone_model_id',
        'repair_service_id',
        'device_color',
        'imei_serial',
        'device_passcode',
        'symptom_description',
        'device_condition',
        'service_type',
        'status',
        'priority',
        'estimated_cost',
        'final_cost',
        'technician_notes',
        'assigned_to',
        'warranty_until',
        'completed_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'warranty_until' => 'date',
            'completed_at' => 'datetime',
            'delivered_at' => 'datetime',
            'estimated_cost' => 'decimal:2',
            'final_cost' => 'decimal:2',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function phoneModel()
    {
        return $this->belongsTo(PhoneModel::class);
    }

    public function repairService()
    {
        return $this->belongsTo(RepairService::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function statusLogs()
    {
        return $this->hasMany(RepairStatusLog::class)->orderBy('created_at', 'desc');
    }

    public function getStatusThaiAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'รอรับเครื่อง / รอตรวจสอบ',
            'inspecting' => 'กำลังตรวจเช็คอาการ',
            'waiting_parts' => 'รออะไหล่แท้',
            'repairing' => 'กำลังดำเนินการซ่อม',
            'completed' => 'ซ่อมเสร็จแล้ว (รอรับเครื่อง)',
            'delivered' => 'ส่งมอบเครื่องแล้ว',
            'cancelled' => 'ยกเลิกการแจ้งซ่อม',
            default => 'ไม่ระบุ',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'inspecting' => 'info',
            'waiting_parts' => 'secondary',
            'repairing' => 'primary',
            'completed' => 'success',
            'delivered' => 'dark',
            'cancelled' => 'danger',
            default => 'light',
        };
    }

    public function getProgressStepAttribute(): int
    {
        return match ($this->status) {
            'pending' => 1,
            'inspecting' => 2,
            'waiting_parts', 'repairing' => 3,
            'completed' => 4,
            'delivered' => 5,
            'cancelled' => 0,
            default => 1,
        };
    }
}
