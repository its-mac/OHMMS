<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'hostel_id',
        'name',
        'status',
    ];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }
}
