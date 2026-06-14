@extends('layouts.app', ['title' => 'Fee Detail'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Fee Detail</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Invoice / Challan</h5>

        <table class="table table-bordered">
            <tr><th width="220">Invoice No</th><td>{{ $invoice->invoice_no }}</td></tr>
            <tr><th>Month</th><td>{{ \Carbon\Carbon::create()->month($invoice->month)->format('F') }} {{ $invoice->year }}</td></tr>
            <tr><th>Invoice Date</th><td>{{ $invoice->invoice_date->format('d M Y') }}</td></tr>
            <tr><th>Due Date</th><td>{{ $invoice->due_date->format('d M Y') }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($invoice->status) }}</td></tr>
        </table>

        <h6>Fee Items</h6>

        <table class="table table-bordered">
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>Rs. {{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach

            <tr><th>Total</th><th>Rs. {{ number_format($invoice->total_amount, 2) }}</th></tr>
            <tr><th>Paid</th><th>Rs. {{ number_format($invoice->paid_amount, 2) }}</th></tr>
            <tr><th>Remaining</th><th>Rs. {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</th></tr>
        </table>

        <h6>Payment History</h6>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_date->format('d M Y') }}</td>
                        <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No payments recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('student.fees.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
