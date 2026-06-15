@extends('layouts.app', ['title' => 'Invoice Detail'])

@section('content')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="page-header no-print">
        <div class="page-block">
            <h5 class="mb-0">Invoice Detail</h5>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success no-print">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <div class="no-print mb-3">
                <button onclick="window.print()" class="btn btn-primary">
                    Print Challan
                </button>

                <a href="{{ route('manager.invoices.index') }}" class="btn btn-light">
                    Back
                </a>
            </div>

            <div id="print-area">

                <div class="text-center mb-4">
                    <h3 class="mb-0">OHMMS</h3>
                    <p class="mb-1">Online Hostel & Mess Management System</p>
                    <h5>Fee Challan / Invoice</h5>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th width="220">Invoice No</th>
                        <td>{{ $invoice->invoice_no }}</td>
                        <th width="220">Status</th>
                        <td>{{ ucfirst($invoice->status) }}</td>
                    </tr>

                    <tr>
                        <th>Student Name</th>
                        <td>{{ $invoice->student->name ?? '-' }}</td>
                        <th>Registration No</th>
                        <td>{{ $invoice->student->registration_no ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Month</th>
                        <td>{{ \Carbon\Carbon::create()->month($invoice->month)->format('F') }} {{ $invoice->year }}</td>
                        <th>Due Date</th>
                        <td>{{ $invoice->due_date->format('d M Y') }}</td>
                    </tr>

                    <tr>
                        <th>Invoice Date</th>
                        <td>{{ $invoice->invoice_date->format('d M Y') }}</td>
                        <th>Generated On</th>
                        <td>{{ now()->format('d M Y') }}</td>
                    </tr>
                </table>

                <h6 class="mt-4">Fee Details</h6>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="70">#</th>
                            <th>Fee Item</th>
                            <th width="220">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>Rs. {{ number_format($item->amount, 2) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <th colspan="2" class="text-end">Total Amount</th>
                            <th>Rs. {{ number_format($invoice->total_amount, 2) }}</th>
                        </tr>

                        <tr>
                            <th colspan="2" class="text-end">Paid Amount</th>
                            <th>Rs. {{ number_format($invoice->paid_amount, 2) }}</th>
                        </tr>

                        <tr>
                            <th colspan="2" class="text-end">Outstanding Amount</th>
                            <th>Rs. {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</th>
                        </tr>
                    </tbody>
                </table>

                <div class="row mt-5">
                    <div class="col-md-6">
                        <p><strong>Student Signature:</strong> ________________________</p>
                    </div>

                    <div class="col-md-6 text-end">
                        <p><strong>Manager Signature:</strong> ________________________</p>
                    </div>
                </div>

                <div class="mt-4">
                    <small>
                        Note: Please pay the dues before the due date. Late payment may be subject to fine according to
                        hostel policy.
                    </small>
                </div>

            </div>
        </div>
    </div>

    @if ($invoice->status !== 'paid')
        <div class="card no-print">
            <div class="card-header">
                <h5>Record Payment</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('manager.invoices.payments.store', $invoice) }}"
                    enctype="multipart/form-data">
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

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Reference No</label>
                            <input type="text" name="reference_no" value="{{ old('reference_no') }}"
                                class="form-control @error('reference_no') is-invalid @enderror"
                                placeholder="Transaction ID / Cheque No">

                            @error('reference_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Receipt / Slip</label>
                        <input type="file" name="receipt" class="form-control @error('receipt') is-invalid @enderror"
                            accept="image/*,.pdf">

                        @error('receipt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

    <div class="card no-print">
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
                    <th>Reference</th>
                    <th>Receipt</th>
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                @forelse($invoice->payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_date->format('d M Y') }}</td>
                        <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        <td>{{ $payment->reference_no ?? '-' }}</td>
                        <td>
                            @if ($payment->receipt)
                                <button type="button"
                                    class="btn btn-sm btn-light"
                                    data-bs-toggle="modal"
                                    data-bs-target="#receiptModal{{ $payment->id }}">
                                    <i class="ph ph-file-image me-1"></i> Receipt
                                </button>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $payment->remarks ?? '-' }}</td>
                    </tr>

                    @if ($payment->receipt)
                        <div class="modal fade"
                            id="receiptModal{{ $payment->id }}"
                            tabindex="-1"
                            aria-hidden="true">

                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Payment Receipt</h5>

                                        <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close">
                                        </button>
                                    </div>

                                    <div class="modal-body text-center">
                                        @php
                                            $extension = strtolower(pathinfo($payment->receipt, PATHINFO_EXTENSION));
                                            $receiptUrl = asset('storage/' . $payment->receipt);
                                        @endphp

                                        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <img src="{{ $receiptUrl }}"
                                                class="img-fluid rounded"
                                                alt="Payment Receipt">
                                        @elseif ($extension === 'pdf')
                                            <iframe src="{{ $receiptUrl }}"
                                                width="100%"
                                                height="700"
                                                style="border: none;">
                                            </iframe>
                                        @else
                                            <a href="{{ $receiptUrl }}"
                                                class="btn btn-primary"
                                                download>
                                                Download Receipt
                                            </a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No payments recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
