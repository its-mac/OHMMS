<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request, Invoice $invoice)
    {
        $remainingAmount = $invoice->total_amount - $invoice->paid_amount;

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:' . $remainingAmount],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,bank_transfer,jazzcash,easypaisa,cheque'],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'receipt' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($request, $invoice, $validated) {
            $receiptPath = null;

            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')->store('payment-receipts', 'public');
            }

            Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'reference_no' => $validated['reference_no'] ?? null,
                'receipt' => $receiptPath,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            $newPaidAmount = $invoice->paid_amount + $validated['amount'];

            $status = match (true) {
                $newPaidAmount >= $invoice->total_amount => 'paid',
                $newPaidAmount > 0 => 'partial',
                default => 'unpaid',
            };

            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'status' => $status,
            ]);
        });

        return redirect()
            ->route('manager.invoices.show', $invoice)
            ->with('success', 'Payment recorded successfully.');
    }
}
