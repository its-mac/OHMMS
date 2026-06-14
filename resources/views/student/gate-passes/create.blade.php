@extends('layouts.app', ['title' => 'Apply Gate Pass'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Apply Gate Pass</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('student.gate-passes.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Out Time</label>
                <input type="datetime-local" name="out_time" value="{{ old('out_time') }}"
                       class="form-control @error('out_time') is-invalid @enderror">
                @error('out_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Expected Return Time</label>
                <input type="datetime-local" name="expected_return_time" value="{{ old('expected_return_time') }}"
                       class="form-control @error('expected_return_time') is-invalid @enderror">
                @error('expected_return_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Destination</label>
                <input type="text" name="destination" value="{{ old('destination') }}"
                       class="form-control @error('destination') is-invalid @enderror">
                @error('destination') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Purpose</label>
                <input type="text" name="purpose" value="{{ old('purpose') }}"
                       class="form-control @error('purpose') is-invalid @enderror">
                @error('purpose') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contact During Outing</label>
                <input type="text" name="contact_during_outing" value="{{ old('contact_during_outing') }}"
                       class="form-control @error('contact_during_outing') is-invalid @enderror">
                @error('contact_during_outing') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary">Submit Request</button>
            <a href="{{ route('student.gate-passes.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
