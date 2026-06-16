@extends('layouts.app', ['title' => 'My Fees'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">My Fees</h5>
            <small class="text-muted">View your fee challans, payments and outstanding dues</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <h6 class="text-white mb-2">Total Invoices</h6>
                    <h3 class="text-white mb-0">{{ $totalInvoices }}</h3>
                    <p class="text-white-50 mb-0">Generated challans</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-success">
                <div class="card-body">
                    <h6 class="text-white mb-2">Total Amount</h6>
                    <h3 class="text-white mb-0">Rs. {{ number_format($totalAmount, 2) }}</h3>
                    <p class="text-white-50 mb-0">Total fee amount</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-info">
                <div class="card-body">
                    <h6 class="text-white mb-2">Paid Amount</h6>
                    <h3 class="text-white mb-0">Rs. {{ number_format($paidAmount, 2) }}</h3>
                    <p class="text-white-50 mb-0">Verified payments</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <h6 class="text-white mb-2">Outstanding</h6>
                    <h3 class="text-white mb-0">Rs. {{ number_format($outstandingAmount, 2) }}</h3>
                    <p class="text-white-50 mb-0">{{ $unpaidInvoices }} unpaid/partial invoices</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 class="mb-0">My Invoices / Challans</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice No</th>
                            <th>Month</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>
                                    <strong>{{ $invoice->invoice_no }}</strong>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::createFromDate($invoice->year, $invoice->month, 1)->format('F') }}
                                    {{ $invoice->year }}
                                </td>

                                <td>Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                                <td>Rs. {{ number_format($invoice->paid_amount, 2) }}</td>
                                <td>Rs. {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</td>

                                <td>
                                    @if ($invoice->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif ($invoice->status === 'partial')
                                        <span class="badge bg-warning">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('student.fees.show', $invoice) }}" class="btn btn-sm btn-primary">
                                        <i class="ph ph-eye me-1"></i>
                                        View Challan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-5">
                                        <i class="ph ph-file-text text-muted d-block mb-2" style="font-size: 42px;"></i>
                                        <p class="text-muted mb-0">No invoices found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
@endsection
