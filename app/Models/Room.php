<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'floor_id',
        'room_no',
        'capacity',
        'occupied',
        'status',
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function allocations()
    {
        return $this->hasMany(RoomAllocation::class);
    }

    public function activeAllocations()
    {
        return $this->hasMany(RoomAllocation::class)->where('status', 'active');
    }
}
