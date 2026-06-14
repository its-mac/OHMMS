@extends('layouts.app', ['title' => 'Invoices'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Invoices / Challans</h5>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Invoice List</h5>
            <a href="{{ route('manager.invoices.create') }}" class="btn btn-primary btn-sm">
                Generate Invoice
            </a>
        </div>

        <div class="card-body">
            <form method="GET" class="row mb-3">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        @foreach (['unpaid', 'partial', 'paid'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="month" class="form-select">
                        <option value="">All Months</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected(request('month') == $m)>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="number" name="year" value="{{ request('year') }}" class="form-control"
                        placeholder="Year">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('manager.invoices.index') }}" class="btn btn-light">Reset</a>
                </div>
            </form>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Student</th>
                        <th>Month</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Status</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->student->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::create()->month($invoice->month)->format('F') }} {{ $invoice->year }}
                            </td>
                            <td>Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                            <td>Rs. {{ number_format($invoice->paid_amount, 2) }}</td>
                            <td>{{ ucfirst($invoice->status) }}</td>
                            <td>
                                <a href="{{ route('manager.invoices.show', $invoice) }}" class="btn btn-info btn-sm">
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
