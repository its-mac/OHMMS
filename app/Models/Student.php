<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function guestMeals()
    {
        return $this->hasMany(GuestMeal::class);
    }

    public function messOffs()
    {
        return $this->hasMany(MessOff::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function gatePasses()
    {
        return $this->hasMany(GatePass::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
