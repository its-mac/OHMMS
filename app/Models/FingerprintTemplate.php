<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FingerprintTemplate extends Model
{
    protected $fillable = [
        'student_id',
        'finger_index',
        'template_data',
    ];

    protected $hidden = [
        'template_data',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
