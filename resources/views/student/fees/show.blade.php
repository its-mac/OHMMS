@extends('layouts.app', ['title' => 'Fee Detail'])

@section('content')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #student-print-area,
            #student-print-area * {
                visibility: visible;
            }

            #student-print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 25px;
            }

            .no-print {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>

    @php
        $remainingAmount = $invoice->total_amount - $invoice->paid_amount;

        $statusClass = match ($invoice->status) {
            'paid' => 'success',
            'partial' => 'warning',
            default => 'danger',
        };
    @endphp

    <div class="page-header no-print">
        <div class="page-block">
            <h5 class="mb-0">Fee Detail</h5>
            <small class="text-muted">View, print and submit payment proof for your challan</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success no-print">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger no-print">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row no-print">
        <div class="col-md-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <h6 class="text-white mb-2">Total Amount</h6>
                    <h3 class="text-white mb-0">Rs. {{ number_format($invoice->total_amount, 2) }}</h3>
                    <p class="text-white-50 mb-0">Invoice amount</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success">
                <div class="card-body">
                    <h6 class="text-white mb-2">Paid Amount</h6>
                    <h3 class="text-white mb-0">Rs. {{ number_format($invoice->paid_amount, 2) }}</h3>
                    <p class="text-white-50 mb-0">Verified payments</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <h6 class="text-white mb-2">Outstanding</h6>
                    <h3 class="text-white mb-0">Rs. {{ number_format($remainingAmount, 2) }}</h3>
                    <p class="text-white-50 mb-0">Remaining balance</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info">
                <div class="card-body">
                    <h6 class="text-white mb-2">Status</h6>
                    <h3 class="text-white mb-0">{{ ucfirst($invoice->status) }}</h3>
                    <p class="text-white-50 mb-0">Current challan status</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="no-print mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Student Fee Challan</h5>
                    <small class="text-muted">{{ $invoice->invoice_no }}</small>
                </div>

                <div>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="ph ph-printer me-1"></i>
                        Print Challan
                    </button>

                    <a href="{{ route('student.fees.index') }}" class="btn btn-light">
                        Back
                    </a>
                </div>
            </div>

            <div id="student-print-area">
                <div class="border rounded p-4">
                    <div class="text-center mb-4">
                        <h3 class="mb-0">OHMMS</h3>
                        <p class="mb-1">Online Hostel & Mess Management System</p>
                        <h5 class="mb-0">Student Fee Challan</h5>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="mb-1">Invoice No</h6>
                            <h5 class="mb-0">{{ $invoice->invoice_no }}</h5>
                        </div>

                        <div class="text-end">
                            <h6 class="mb-1">Status</h6>
                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th width="220">Student Name</th>
                            <td>{{ $invoice->student->name ?? '-' }}</td>
                            <th width="220">Registration No</th>
                            <td>{{ $invoice->student->registration_no ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Month</th>
                            <td>
                                {{ \Carbon\Carbon::createFromDate($invoice->year, $invoice->month, 1)->format('F') }}
                                {{ $invoice->year }}
                            </td>
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

                    <h6 class="mt-4">Fee Items</h6>

                    <table class="table table-bordered">
                        <thead class="table-light">
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
                                <th>Rs. {{ number_format($remainingAmount, 2) }}</th>
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
                            Note: Please pay the dues before the due date. Late payment may be subject to fine according to hostel policy.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($invoice->status !== 'paid')
        <div class="card no-print">
            <div class="card-header">
                <h5 class="mb-0">Upload Payment Proof</h5>
            </div>

            <div class="card-body">
                <form method="POST"
                      action="{{ route('student.fees.payment-proof.upload', $invoice) }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number"
                                   step="0.01"
                                   name="amount"
                                   value="{{ old('amount', $remainingAmount) }}"
                                   class="form-control @error('amount') is-invalid @enderror">

                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Date</label>
                            <input type="date"
                                   name="payment_date"
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
                                <option value="cash" @selected(old('payment_method') === 'cash')>Cash</option>
                                <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>Bank Transfer</option>
                                <option value="jazzcash" @selected(old('payment_method') === 'jazzcash')>JazzCash</option>
                                <option value="easypaisa" @selected(old('payment_method') === 'easypaisa')>EasyPaisa</option>
                                <option value="cheque" @selected(old('payment_method') === 'cheque')>Cheque</option>
                            </select>

                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reference No</label>
                            <input type="text"
                                   name="reference_no"
                                   value="{{ old('reference_no') }}"
                                   class="form-control @error('reference_no') is-invalid @enderror"
                                   placeholder="Transaction ID / Cheque No">

                            @error('reference_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receipt / Slip</label>
                            <input type="file"
                                   name="receipt"
                                   class="form-control @error('receipt') is-invalid @enderror"
                                   accept="image/*,.pdf">

                            @error('receipt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-primary">
                        <i class="ph ph-upload-simple me-1"></i>
                        Submit Payment Proof
                    </button>
                </form>
            </div>
        </div>
    @endif

    <div class="card no-print">
        <div class="card-header">
            <h5 class="mb-0">Submitted Payment Proofs</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Reference</th>
                            <th>Status</th>
                            <th>Receipt</th>
                            <th>Manager Remarks</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($invoice->paymentProofs as $proof)
                            <tr>
                                <td>{{ $proof->payment_date->format('d M Y') }}</td>
                                <td>Rs. {{ number_format($proof->amount, 2) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $proof->payment_method)) }}</td>
                                <td>{{ $proof->reference_no ?? '-' }}</td>
                                <td>
                                    @if ($proof->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif ($proof->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-light"
                                            data-bs-toggle="modal"
                                            data-bs-target="#proofReceiptModal{{ $proof->id }}">
                                        View
                                    </button>
                                </td>
                                <td>{{ $proof->manager_remarks ?? '-' }}</td>
                            </tr>

                            <div class="modal fade" id="proofReceiptModal{{ $proof->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Payment Proof Receipt</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body text-center">
                                            @php
                                                $extension = strtolower(pathinfo($proof->receipt, PATHINFO_EXTENSION));
                                                $receiptUrl = asset('storage/' . $proof->receipt);
                                            @endphp

                                            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <img src="{{ $receiptUrl }}" class="img-fluid rounded" alt="Payment Proof Receipt">
                                            @elseif ($extension === 'pdf')
                                                <iframe src="{{ $receiptUrl }}" width="100%" height="700" style="border:none;"></iframe>
                                            @else
                                                <a href="{{ $receiptUrl }}" class="btn btn-primary" download>Download Receipt</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-4 text-muted">
                                        No payment proofs submitted.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card no-print">
        <div class="card-header">
            <h5 class="mb-0">Payment History</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
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
                                                data-bs-target="#studentReceiptModal{{ $payment->id }}">
                                            Receipt
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $payment->remarks ?? '-' }}</td>
                            </tr>

                            @if ($payment->receipt)
                                <div class="modal fade" id="studentReceiptModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Payment Receipt</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body text-center">
                                                @php
                                                    $extension = strtolower(pathinfo($payment->receipt, PATHINFO_EXTENSION));
                                                    $receiptUrl = asset('storage/' . $payment->receipt);
                                                @endphp

                                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                    <img src="{{ $receiptUrl }}" class="img-fluid rounded" alt="Payment Receipt">
                                                @elseif ($extension === 'pdf')
                                                    <iframe src="{{ $receiptUrl }}" width="100%" height="700" style="border:none;"></iframe>
                                                @else
                                                    <a href="{{ $receiptUrl }}" class="btn btn-primary" download>Download Receipt</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="text-center py-4 text-muted">
                                        No payments recorded.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
