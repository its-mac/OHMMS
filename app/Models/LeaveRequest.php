<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'student_id',
        'from_date',
        'to_date',
        'destination',
        'contact_during_leave',
        'reason',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
