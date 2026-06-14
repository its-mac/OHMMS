<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'student_id',
        'category',
        'subject',
        'description',
        'status',
        'manager_response',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
