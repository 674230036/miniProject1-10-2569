<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairService extends Model
{
    protected $fillable = [
        'name',
        'category',
        'icon',
        'description',
        'estimated_duration',
        'warranty_period',
        'base_price',
        'is_active',
    ];

    public function repairTickets()
    {
        return $this->hasMany(RepairTicket::class);
    }
}
