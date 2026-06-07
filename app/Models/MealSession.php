<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealSession extends Model
{
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'is_active',
    ];

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function messMenus()
    {
        return $this->hasMany(MessMenu::class);
    }
}
