<?php

namespace App\Http\Controllers\Student;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PaymentProof;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $query = Invoice::where('student_id', $student->id);

        $totalInvoices = (clone $query)->count();
        $totalAmount = (clone $query)->sum('total_amount');
        $paidAmount = (clone $query)->sum('paid_amount');
        $outstandingAmount = $totalAmount - $paidAmount;

        $unpaidInvoices = (clone $query)
            ->whereIn('status', ['unpaid', 'partial'])
            ->count();

        $invoices = $query->latest()->paginate(10);

        return view('student.fees.index', compact(
            'invoices',
            'totalInvoices',
            'totalAmount',
            'paidAmount',
            'outstandingAmount',
            'unpaidInvoices'
        ));
    }

    public function show(Invoice $invoice)
    {
        $student = auth()->user()->student;

        abort_if(!$student || $invoice->student_id !== $student->id, 403);

        $invoice->load(['student', 'items', 'payments', 'paymentProofs']);

        return view('student.fees.show', compact('invoice'));
    }

    public function uploadPaymentProof(Request $request, Invoice $invoice)
    {
        $student = auth()->user()->student;

        abort_if(!$student || $invoice->student_id !== $student->id, 403);

        $remainingAmount = $invoice->total_amount - $invoice->paid_amount;

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:' . $remainingAmount],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,bank_transfer,jazzcash,easypaisa,cheque'],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'receipt' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $receiptPath = $request->file('receipt')->store('payment-proofs', 'public');

        PaymentProof::create([
            'invoice_id' => $invoice->id,
            'student_id' => $student->id,
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'reference_no' => $validated['reference_no'] ?? null,
            'receipt' => $receiptPath,
            'status' => 'pending',
        ]);

        NotificationHelper::sendToRole(
            'manager',
            'New Payment Proof Submitted',
            auth()->user()->name . ' submitted payment proof for invoice ' . $invoice->invoice_no . '.',
            route('manager.payment-proofs.index'),
            'payment_proof'
        );

        return redirect()
            ->route('student.fees.show', $invoice)
            ->with('success', 'Payment proof submitted successfully. Please wait for manager verification.');
    }
}
