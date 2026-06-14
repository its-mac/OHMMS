<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessOff extends Model
{
    protected $fillable = [
        'student_id',
        'from_date',
        'to_date',
        'reason',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
