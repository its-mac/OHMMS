<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentProof extends Model
{
    protected $fillable = [
        'invoice_id',
        'student_id',
        'amount',
        'payment_date',
        'payment_method',
        'reference_no',
        'receipt',
        'status',
        'manager_remarks',
        'reviewed_at',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
