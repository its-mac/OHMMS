<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'student_id',
        'invoice_no',
        'invoice_date',
        'due_date',
        'month',
        'year',
        'total_amount',
        'paid_amount',
        'status',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentProofs()
    {
        return $this->hasMany(PaymentProof::class);
    }
}
