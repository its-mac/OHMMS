@extends('layouts.app', ['title' => 'Payment Proofs'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Payment Proof Verification</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Filter Payment Proofs</h5>
    </div>

    <div class="card-body">
        <form method="GET" class="row">

            <div class="col-md-3 mb-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>

                    <option value="pending"
                        @selected(request('status') == 'pending')>
                        Pending
                    </option>

                    <option value="approved"
                        @selected(request('status') == 'approved')>
                        Approved
                    </option>

                    <option value="rejected"
                        @selected(request('status') == 'rejected')>
                        Rejected
                    </option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <button class="btn btn-primary">
                    Filter
                </button>

                <a href="{{ route('manager.payment-proofs.index') }}"
                   class="btn btn-light">
                    Reset
                </a>
            </div>

        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Submitted Payment Proofs</h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Invoice No</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th width="120">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($paymentProofs as $proof)

                    <tr>

                        <td>
                            {{ $proof->student->name ?? '-' }}
                            <br>
                            <small>
                                {{ $proof->student->registration_no ?? '' }}
                            </small>
                        </td>

                        <td>{{ $proof->invoice->invoice_no ?? '-' }}</td>

                        <td>
                            Rs. {{ number_format($proof->amount, 2) }}
                        </td>

                        <td>
                            {{ ucfirst(str_replace('_', ' ', $proof->payment_method)) }}
                        </td>

                        <td>
                            @if($proof->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($proof->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>

                        <td>
                            {{ $proof->payment_date->format('d M Y') }}
                        </td>

                        <td>
                            <a href="{{ route('manager.payment-proofs.show', $proof) }}"
                               class="btn btn-sm btn-primary">
                                Review
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            No payment proofs found.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

        {{ $paymentProofs->links() }}

    </div>
</div>

@endsection
