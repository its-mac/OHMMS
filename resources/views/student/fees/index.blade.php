@extends('layouts.app', ['title' => 'My Fees'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">My Fees</h5>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>My Invoices / Challans</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Month</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Remaining</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_no }}</td>
                        <td>{{ \Carbon\Carbon::create()->month($invoice->month)->format('F') }} {{ $invoice->year }}</td>
                        <td>Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                        <td>Rs. {{ number_format($invoice->paid_amount, 2) }}</td>
                        <td>Rs. {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</td>
                        <td>{{ ucfirst($invoice->status) }}</td>
                        <td>
                            <a href="{{ route('student.fees.show', $invoice) }}" class="btn btn-info btn-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $invoices->links() }}
    </div>
</div>
@endsection
