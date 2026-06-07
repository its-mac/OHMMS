<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAllocation extends Model
{
    protected $fillable = [
        'student_id',
        'room_id',
        'allocated_at',
        'released_at',
        'status',
    ];

    protected $casts = [
        'allocated_at' => 'date',
        'released_at' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
