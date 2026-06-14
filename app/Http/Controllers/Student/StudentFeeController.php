<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class StudentFeeController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $invoices = Invoice::where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.fees.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $student = auth()->user()->student;

        abort_if(!$student || $invoice->student_id !== $student->id, 403);

        $invoice->load(['items', 'payments']);

        return view('student.fees.show', compact('invoice'));
    }
}
