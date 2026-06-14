<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('student')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $invoices = $query->paginate(10)->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')->orderBy('name')->get();
        $feeStructures = FeeStructure::where('status', 'active')->orderBy('name')->get();

        return view('invoices.create', compact('students', 'feeStructures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'min:2024', 'max:2100'],
            'due_date' => ['required', 'date'],
            'fee_structure_ids' => ['required', 'array'],
            'fee_structure_ids.*' => ['exists:fee_structures,id'],
        ]);

        $exists = Invoice::where('student_id', $validated['student_id'])
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['student_id' => 'Invoice already exists for this student in selected month/year.']);
        }

        DB::transaction(function () use ($validated) {
            $fees = FeeStructure::whereIn('id', $validated['fee_structure_ids'])->get();

            $invoice = Invoice::create([
                'student_id' => $validated['student_id'],
                'invoice_no' => 'INV-' . now()->format('YmdHis') . '-' . rand(100, 999),
                'invoice_date' => now()->toDateString(),
                'due_date' => $validated['due_date'],
                'month' => $validated['month'],
                'year' => $validated['year'],
                'total_amount' => $fees->sum('amount'),
                'paid_amount' => 0,
                'status' => 'unpaid',
            ]);

            foreach ($fees as $fee) {
                $invoice->items()->create([
                    'fee_structure_id' => $fee->id,
                    'title' => $fee->name,
                    'amount' => $fee->amount,
                ]);
            }
        });

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'Invoice generated successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['student', 'items', 'payments']);

        return view('invoices.show', compact('invoice'));
    }
}
