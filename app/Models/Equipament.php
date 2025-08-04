<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipament extends Model
{
    protected $casts = [
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
}
