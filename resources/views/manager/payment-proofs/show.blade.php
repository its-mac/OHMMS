@extends('layouts.app', ['title' => 'Payment Proof Review'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Payment Proof Review</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Payment Proof Details</h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="220">Student</th>
                <td>{{ $paymentProof->student->name }}</td>
            </tr>

            <tr>
                <th>Registration No</th>
                <td>{{ $paymentProof->student->registration_no }}</td>
            </tr>

            <tr>
                <th>Invoice No</th>
                <td>{{ $paymentProof->invoice->invoice_no }}</td>
            </tr>

            <tr>
                <th>Amount</th>
                <td>Rs. {{ number_format($paymentProof->amount, 2) }}</td>
            </tr>

            <tr>
                <th>Payment Date</th>
                <td>{{ $paymentProof->payment_date->format('d M Y') }}</td>
            </tr>

            <tr>
                <th>Payment Method</th>
                <td>
                    {{ ucfirst(str_replace('_', ' ', $paymentProof->payment_method)) }}
                </td>
            </tr>

            <tr>
                <th>Reference No</th>
                <td>{{ $paymentProof->reference_no ?? '-' }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    @if($paymentProof->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif($paymentProof->status == 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th>Receipt</th>
                <td>

                    @php
                        $receiptUrl = asset('storage/' . $paymentProof->receipt);
                        $extension = strtolower(pathinfo($paymentProof->receipt, PATHINFO_EXTENSION));
                    @endphp

                    @if(in_array($extension, ['jpg','jpeg','png','gif','webp']))
                        <img src="{{ $receiptUrl }}"
                             class="img-fluid rounded"
                             style="max-height:500px;">
                    @elseif($extension === 'pdf')
                        <iframe src="{{ $receiptUrl }}"
                                width="100%"
                                height="700"
                                style="border:none;">
                        </iframe>
                    @else
                        <a href="{{ $receiptUrl }}"
                           class="btn btn-primary"
                           target="_blank">
                            Download Receipt
                        </a>
                    @endif

                </td>
            </tr>

            @if($paymentProof->manager_remarks)
                <tr>
                    <th>Manager Remarks</th>
                    <td>{{ $paymentProof->manager_remarks }}</td>
                </tr>
            @endif

        </table>

    </div>
</div>

@if($paymentProof->status === 'pending')

<div class="row">

    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h5>Approve Payment</h5>
            </div>

            <div class="card-body">

                <form method="POST"
                      action="{{ route('manager.payment-proofs.approve', $paymentProof) }}">

                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">
                            Remarks
                        </label>

                        <textarea name="manager_remarks"
                                  rows="4"
                                  class="form-control"></textarea>
                    </div>

                    <button class="btn btn-success">
                        Approve Payment
                    </button>

                </form>

            </div>
        </div>

    </div>

    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h5>Reject Payment</h5>
            </div>

            <div class="card-body">

                <form method="POST"
                      action="{{ route('manager.payment-proofs.reject', $paymentProof) }}">

                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">
                            Rejection Reason
                        </label>

                        <textarea name="manager_remarks"
                                  rows="4"
                                  class="form-control"
                                  required></textarea>
                    </div>

                    <button class="btn btn-danger">
                        Reject Payment
                    </button>

                </form>

            </div>
        </div>

    </div>

</div>

@endif

<div class="mt-3">
    <a href="{{ route('manager.payment-proofs.index') }}"
       class="btn btn-light">
        Back
    </a>
</div>

@endsection
