<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
    protected $fillable = [
        'student_id',
        'out_time',
        'expected_return_time',
        'destination',
        'purpose',
        'contact_during_outing',
        'status',
    ];

    protected $casts = [
        'out_time' => 'datetime',
        'expected_return_time' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
