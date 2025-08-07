<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipamentAvailability extends Model
{
    protected $fillable = [
        'equipament_id',
        'user_id',
        'start_date',
        'end_date',
        'is_available',
        'status',
        'price',
        'description',
        'notes',
    ];
}
