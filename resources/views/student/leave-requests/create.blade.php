@extends('layouts.app', ['title' => 'Apply Leave'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Apply Leave</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('student.leave-requests.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" value="{{ old('from_date') }}"
                       class="form-control @error('from_date') is-invalid @enderror">
                @error('from_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" value="{{ old('to_date') }}"
                       class="form-control @error('to_date') is-invalid @enderror">
                @error('to_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Destination</label>
                <input type="text" name="destination" value="{{ old('destination') }}"
                       class="form-control @error('destination') is-invalid @enderror">
                @error('destination') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contact During Leave</label>
                <input type="text" name="contact_during_leave" value="{{ old('contact_during_leave') }}"
                       class="form-control @error('contact_during_leave') is-invalid @enderror">
                @error('contact_during_leave') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Reason</label>
                <textarea name="reason" rows="4"
                          class="form-control @error('reason') is-invalid @enderror">{{ old('reason') }}</textarea>
                @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary">Submit Request</button>
            <a href="{{ route('student.leave-requests.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
