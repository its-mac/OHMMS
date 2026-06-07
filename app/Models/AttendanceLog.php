<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $fillable = [
        'student_id',
        'meal_session_id',
        'attendance_date',
        'attendance_time',
        'verification_method',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function mealSession()
    {
        return $this->belongsTo(MealSession::class);
    }
}
