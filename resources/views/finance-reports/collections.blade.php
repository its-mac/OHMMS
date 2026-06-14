@extends('layouts.app', ['title' => 'Collection Report'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Collection Report</h5>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Filter Collections</h5>
    </div>

    <div class="card-body">
        <form method="GET" class="row">
            <div class="col-md-3 mb-3">
                <select name="month" class="form-select">
                    <option value="">All Months</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" @selected(request('month') == $m)>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <input type="number" name="year" value="{{ request('year') }}" class="form-control" placeholder="Year">
            </div>

            <div class="col-md-3 mb-3">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route(auth()->user()->role . '.finance-reports.collections') }}" class="btn btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card"><div class="card-body">
            <h6>Total Generated</h6>
            <h3>Rs. {{ number_format($totalGenerated, 2) }}</h3>
        </div></div>
    </div>

    <div class="col-md-4">
        <div class="card"><div class="card-body">
            <h6>Total Collected</h6>
            <h3>Rs. {{ number_format($totalCollected, 2) }}</h3>
        </div></div>
    </div>

    <div class="col-md-4">
        <div class="card"><div class="card-body">
            <h6>Total Outstanding</h6>
            <h3>Rs. {{ number_format($totalOutstanding, 2) }}</h3>
        </div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Collection Details</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Student</th>
                    <th>Month</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Outstanding</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_no }}</td>
                        <td>{{ $invoice->student->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::create()->month($invoice->month)->format('F') }} {{ $invoice->year }}</td>
                        <td>Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                        <td>Rs. {{ number_format($invoice->paid_amount, 2) }}</td>
                        <td>Rs. {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</td>
                        <td>{{ ucfirst($invoice->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No collection records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $invoices->links() }}
    </div>
</div>
@endsection
