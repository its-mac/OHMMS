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
        'is_escalated',
        'escalated_at',
        'escalation_reason',
        'admin_response',
        'admin_reviewed_at',
    ];

    protected $casts = [
        'is_escalated' => 'boolean',
        'escalated_at' => 'datetime',
        'admin_reviewed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
