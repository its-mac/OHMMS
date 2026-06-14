@extends('layouts.app', ['title' => 'Invoice Detail'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Invoice Detail</h5>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5>Challan / Invoice</h5>

            <table class="table table-bordered">
                <tr>
                    <th width="220">Invoice No</th>
                    <td>{{ $invoice->invoice_no }}</td>
                </tr>
                <tr>
                    <th>Student</th>
                    <td>{{ $invoice->student->registration_no }} - {{ $invoice->student->name }}</td>
                </tr>
                <tr>
                    <th>Month</th>
                    <td>{{ \Carbon\Carbon::create()->month($invoice->month)->format('F') }} {{ $invoice->year }}</td>
                </tr>
                <tr>
                    <th>Invoice Date</th>
                    <td>{{ $invoice->invoice_date->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Due Date</th>
                    <td>{{ $invoice->due_date->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($invoice->status) }}</td>
                </tr>
            </table>

            <h6>Fee Items</h6>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Fee Item</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>Rs. {{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Total</th>
                        <th>Rs. {{ number_format($invoice->total_amount, 2) }}</th>
                    </tr>
                    <tr>
                        <th>Paid</th>
                        <th>Rs. {{ number_format($invoice->paid_amount, 2) }}</th>
                    </tr>
                    <tr>
                        <th>Remaining</th>
                        <th>Rs. {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if ($invoice->status !== 'paid')
        <div class="card">
            <div class="card-header">
                <h5>Record Payment</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('manager.invoices.payments.store', $invoice) }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                                class="form-control @error('amount') is-invalid @enderror">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Date</label>
                            <input type="date" name="payment_date"
                                value="{{ old('payment_date', now()->toDateString()) }}"
                                class="form-control @error('payment_date') is-invalid @enderror">
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                                <option value="">Select Method</option>
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="jazzcash">JazzCash</option>
                                <option value="easypaisa">EasyPaisa</option>
                                <option value="cheque">Cheque</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" rows="3" class="form-control">{{ old('remarks') }}</textarea>
                    </div>

                    <button class="btn btn-primary">Record Payment</button>
                </form>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Payment History</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoice->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('d M Y') }}</td>
                            <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>{{ $payment->remarks ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No payments recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <a href="{{ route('manager.invoices.index') }}" class="btn btn-light">Back</a>
        </div>
    </div>
@endsection
