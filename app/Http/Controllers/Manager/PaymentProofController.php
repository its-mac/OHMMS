<?php

namespace App\Http\Controllers\Manager;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentProofController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentProof::with(['student', 'invoice'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $paymentProofs = $query->paginate(10)->withQueryString();

        return view('manager.payment-proofs.index', compact('paymentProofs'));
    }

    public function show(PaymentProof $paymentProof)
    {
        $paymentProof->load(['student', 'invoice']);

        return view('manager.payment-proofs.show', compact('paymentProof'));
    }

    public function approve(Request $request, PaymentProof $paymentProof)
    {
        abort_if($paymentProof->status !== 'pending', 403);

        $validated = $request->validate([
            'manager_remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($paymentProof, $validated) {
            $invoice = $paymentProof->invoice;

            $remainingAmount = $invoice->total_amount - $invoice->paid_amount;

            abort_if($paymentProof->amount > $remainingAmount, 422, 'Payment amount exceeds remaining invoice amount.');

            Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $paymentProof->amount,
                'payment_date' => $paymentProof->payment_date,
                'payment_method' => $paymentProof->payment_method,
                'reference_no' => $paymentProof->reference_no,
                'receipt' => $paymentProof->receipt,
                'remarks' => $validated['manager_remarks'] ?? 'Approved from student payment proof.',
            ]);

            $newPaidAmount = $invoice->paid_amount + $paymentProof->amount;

            $status = match (true) {
                $newPaidAmount >= $invoice->total_amount => 'paid',
                $newPaidAmount > 0 => 'partial',
                default => 'unpaid',
            };

            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'status' => $status,
            ]);

            $paymentProof->update([
                'status' => 'approved',
                'manager_remarks' => $validated['manager_remarks'] ?? null,
                'reviewed_at' => now(),
            ]);

            if ($paymentProof->student?->user_id) {
                NotificationHelper::sendToUser(
                    $paymentProof->student->user_id,
                    'Payment Proof Approved',
                    'Your payment proof for invoice ' . $invoice->invoice_no . ' has been approved.',
                    route('student.fees.show', $invoice),
                    'payment_proof'
                );
            }
        });

        return redirect()
            ->route('manager.payment-proofs.show', $paymentProof)
            ->with('success', 'Payment proof approved and invoice updated successfully.');
    }

    public function reject(Request $request, PaymentProof $paymentProof)
    {
        abort_if($paymentProof->status !== 'pending', 403);

        $validated = $request->validate([
            'manager_remarks' => ['required', 'string', 'max:1000'],
        ]);

        $paymentProof->update([
            'status' => 'rejected',
            'manager_remarks' => $validated['manager_remarks'],
            'reviewed_at' => now(),
        ]);

        if ($paymentProof->student?->user_id) {
            NotificationHelper::sendToUser(
                $paymentProof->student->user_id,
                'Payment Proof Rejected',
                'Your payment proof has been rejected. Please review the manager remarks.',
                route('student.fees.show', $paymentProof->invoice),
                'payment_proof'
            );
        }

        return redirect()
            ->route('manager.payment-proofs.show', $paymentProof)
            ->with('success', 'Payment proof rejected successfully.');
    }
}
