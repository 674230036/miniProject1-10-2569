<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'line_id',
        'address',
        'notes',
    ];

    public function repairTickets()
    {
        return $this->hasMany(RepairTicket::class);
    }
}
