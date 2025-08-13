<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class EquipamentAvailability extends Model
{
    use HasFactory;

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

   public function equipament()
    {
        return $this->belongsTo(\App\Models\Equipament::class, 'equipament_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
