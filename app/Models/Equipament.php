<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipament extends Model
{
    use HasFactory;

    protected $casts = [
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function users() {
        return $this->belongsToMany(\App\Models\User::class, 'equipament_user', 'equipament_id', 'user_id')->withTimestamps();
    }

     

    protected $fillable = ['title', 'user_id', 'description', 'value', 'image', 'private'];

    public function availabilities()
    {
        return $this->hasMany(\App\Models\EquipamentAvailability::class);
    }

    public function reservation() {
        return $this->hasMany(EquipamentAvailability::class);
    }
    public function rentedEquipaments() {
        return $this->hasMany(EquipamentAvailability::class, 'equipament_id');
    }
    public function owner() {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

}
