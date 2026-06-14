<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestMeal extends Model
{
    protected $fillable = [
        'student_id',
        'meal_session_id',
        'meal_date',
        'guest_count',
        'remarks',
        'status',
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
