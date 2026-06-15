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
                'invoice_no' => $this->generateInvoiceNumber(),
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
            ->route('manager.invoices.index')
            ->with('success', 'Invoice generated successfully.');
    }

    public function generateMonthly()
    {
        $feeStructures = FeeStructure::where('status', 'active')
            ->orderBy('name')
            ->get();

        $activeStudentsCount = Student::where('status', 'active')->count();

        return view('invoices.generate-monthly', compact(
            'feeStructures',
            'activeStudentsCount'
        ));
    }

    public function storeMonthly(Request $request)
    {
        $validated = $request->validate([
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'min:2024', 'max:2100'],
            'due_date' => ['required', 'date'],
            'fee_structure_ids' => ['required', 'array'],
            'fee_structure_ids.*' => ['exists:fee_structures,id'],
        ]);

        $students = Student::where('status', 'active')->get();

        $fees = FeeStructure::where('status', 'active')
            ->whereIn('id', $validated['fee_structure_ids'])
            ->get();

        if ($students->isEmpty()) {
            return back()->withErrors([
                'students' => 'No active students found.',
            ]);
        }

        if ($fees->isEmpty()) {
            return back()->withErrors([
                'fee_structure_ids' => 'No active fee structures selected.',
            ]);
        }

        $generated = 0;
        $skipped = 0;

        DB::transaction(function () use ($students, $fees, $validated, &$generated, &$skipped) {
            foreach ($students as $student) {
                $exists = Invoice::where('student_id', $student->id)
                    ->where('month', $validated['month'])
                    ->where('year', $validated['year'])
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                $invoice = Invoice::create([
                    'student_id' => $student->id,
                    'invoice_no' => $this->generateInvoiceNumber(),
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

                $generated++;
            }
        });

        return redirect()
            ->route('manager.invoices.index', [
                'month' => $validated['month'],
                'year' => $validated['year'],
            ])
            ->with(
                'success',
                "Monthly invoices generated successfully. Generated: {$generated}, Skipped existing: {$skipped}."
            );
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['student', 'items', 'payments']);

        return view('invoices.show', compact('invoice'));
    }

    private function generateInvoiceNumber(): string
    {
        do {
            $invoiceNo = 'INV-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);
        } while (Invoice::where('invoice_no', $invoiceNo)->exists());

        return $invoiceNo;
    }
}
