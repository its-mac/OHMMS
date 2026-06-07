<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'registration_no',
        'name',
        'father_name',
        'cnic',
        'department',
        'session',
        'hostel',
        'room_no',
        'phone',
        'email',
        'photo',
        'blood_group',
        'address',
        'guardian_name',
        'guardian_phone',
        'emergency_contact',
        'fingerprint_enrolled',
        'status',
    ];

    public function fingerprints()
    {
        return $this->hasMany(FingerprintTemplate::class);
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function roomAllocations()
    {
        return $this->hasMany(RoomAllocation::class);
    }

    public function activeRoomAllocation()
    {
        return $this->hasOne(RoomAllocation::class)->where('status', 'active');
    }
}
