@extends('layouts.app', ['title' => 'Apply Gate Pass'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Apply Gate Pass</h5>
            <small class="text-muted">Submit your outing request for manager approval</small>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Gate Pass Request Form</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('student.gate-passes.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Out Time</label>
                                <input type="datetime-local" name="out_time" value="{{ old('out_time') }}"
                                    class="form-control @error('out_time') is-invalid @enderror">
                                @error('out_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expected Return Time</label>
                                <input type="datetime-local" name="expected_return_time" value="{{ old('expected_return_time') }}"
                                    class="form-control @error('expected_return_time') is-invalid @enderror">
                                @error('expected_return_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Destination</label>
                            <input type="text" name="destination" value="{{ old('destination') }}"
                                class="form-control @error('destination') is-invalid @enderror"
                                placeholder="Example: Market / Hospital / Home">
                            @error('destination') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Purpose</label>
                            <input type="text" name="purpose" value="{{ old('purpose') }}"
                                class="form-control @error('purpose') is-invalid @enderror"
                                placeholder="Reason for going out">
                            @error('purpose') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contact During Outing</label>
                            <input type="text" name="contact_during_outing" value="{{ old('contact_during_outing') }}"
                                class="form-control @error('contact_during_outing') is-invalid @enderror"
                                placeholder="Phone number during outing">
                            @error('contact_during_outing') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-primary">
                            <i class="ph ph-paper-plane-tilt me-1"></i>
                            Submit Request
                        </button>

                        <a href="{{ route('student.gate-passes.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>Gate Pass Guidelines</h5>
                    <p class="text-muted mb-3">Please provide correct outing details.</p>

                    <ul class="text-muted mb-0">
                        <li>Select accurate out and return time.</li>
                        <li>Mention your destination clearly.</li>
                        <li>Provide active contact number.</li>
                        <li>Wait for manager approval before leaving.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
