@extends('layouts.app', ['title' => 'Generate Invoice'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Generate Invoice</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.invoices.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Student</label>
                <select name="student_id" class="form-select @error('student_id') is-invalid @enderror">
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                            {{ $student->registration_no }} - {{ $student->name }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Month</label>
                    <select name="month" class="form-select">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected(old('month', now()->month) == $m)>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Year</label>
                    <input type="number" name="year" value="{{ old('year', now()->year) }}" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}" class="form-control">
                </div>
            </div>

            <label class="form-label">Fee Items</label>
            @foreach($feeStructures as $fee)
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="fee_structure_ids[]"
                           value="{{ $fee->id }}"
                           id="fee_{{ $fee->id }}">
                    <label class="form-check-label" for="fee_{{ $fee->id }}">
                        {{ $fee->name }} - Rs. {{ number_format($fee->amount, 2) }}
                    </label>
                </div>
            @endforeach
            @error('fee_structure_ids') <div class="text-danger small">{{ $message }}</div> @enderror

            <div class="mt-4">
                <button class="btn btn-primary">Generate Invoice</button>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
