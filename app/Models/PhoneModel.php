<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneModel extends Model
{
    protected $fillable = [
        'name',
        'series',
        'release_year',
        'screen_size',
        'image',
        'base_screen_price',
        'base_battery_price',
        'is_active',
    ];

    public function repairTickets()
    {
        return $this->hasMany(RepairTicket::class);
    }
}
