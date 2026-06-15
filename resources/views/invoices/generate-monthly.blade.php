@extends('layouts.app', ['title' => 'Generate Monthly Fees'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Generate Monthly Fees</h5>
        <small class="text-muted">Generate monthly invoices in bulk for all active students.</small>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Active Students</h6>
                <h3>{{ $activeStudentsCount }}</h3>
                <p class="text-muted mb-0">
                    Invoices will be generated only for active students.
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Monthly Invoice Details</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('manager.invoices.store-monthly') }}">
                    @csrf

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Month</label>
                            <select name="month" class="form-select" required>
                                <option value="">Select Month</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" @selected(old('month') == $m)>
                                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Year</label>
                            <input type="number"
                                   name="year"
                                   value="{{ old('year', now()->year) }}"
                                   class="form-control"
                                   min="2024"
                                   max="2100"
                                   required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date"
                                   name="due_date"
                                   value="{{ old('due_date', now()->addDays(10)->toDateString()) }}"
                                   class="form-control"
                                   required>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fee Items</label>

                        @forelse ($feeStructures as $fee)
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="fee_structure_ids[]"
                                       value="{{ $fee->id }}"
                                       id="fee_{{ $fee->id }}"
                                       checked>

                                <label class="form-check-label" for="fee_{{ $fee->id }}">
                                    {{ $fee->name }} — Rs. {{ number_format($fee->amount, 2) }}
                                </label>
                            </div>
                        @empty
                            <div class="alert alert-warning">
                                No active fee structures found. Please create active fee structures first.
                            </div>
                        @endforelse
                    </div>

                    <div class="alert alert-info">
                        Existing invoices for the same student, month, and year will be skipped automatically.
                    </div>

                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Generate monthly invoices for all active students?')">
                        Generate Monthly Fees
                    </button>

                    <a href="{{ route('manager.invoices.index') }}" class="btn btn-light">
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
