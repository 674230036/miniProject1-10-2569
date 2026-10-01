<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairStatusLog extends Model
{
    protected $fillable = [
        'repair_ticket_id',
        'status',
        'title',
        'note',
        'performed_by',
    ];

    public function repairTicket()
    {
        return $this->belongsTo(RepairTicket::class);
    }
}
