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
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($invoice, $validated) {
            Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'remarks' => $validated['remarks'] ?? null,
            ]);

            $newPaidAmount = $invoice->paid_amount + $validated['amount'];

            if ($newPaidAmount >= $invoice->total_amount) {
                $status = 'paid';
            } elseif ($newPaidAmount > 0) {
                $status = 'partial';
            } else {
                $status = 'unpaid';
            }

            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'status' => $status,
            ]);
        });

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Payment recorded successfully.');
    }
}
