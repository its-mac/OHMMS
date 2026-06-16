@extends('layouts.app', ['title' => 'Apply Leave'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Apply Leave</h5>
            <small class="text-muted">Submit your hostel leave request for manager approval</small>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Leave Request Form</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('student.leave-requests.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date" value="{{ old('from_date') }}"
                                    class="form-control @error('from_date') is-invalid @enderror">
                                @error('from_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" value="{{ old('to_date') }}"
                                    class="form-control @error('to_date') is-invalid @enderror">
                                @error('to_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Destination</label>
                            <input type="text" name="destination" value="{{ old('destination') }}"
                                class="form-control @error('destination') is-invalid @enderror"
                                placeholder="Example: Lahore / Home / Hospital">
                            @error('destination') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contact During Leave</label>
                            <input type="text" name="contact_during_leave" value="{{ old('contact_during_leave') }}"
                                class="form-control @error('contact_during_leave') is-invalid @enderror"
                                placeholder="Phone number during leave">
                            @error('contact_during_leave') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reason</label>
                            <textarea name="reason" rows="5"
                                class="form-control @error('reason') is-invalid @enderror"
                                placeholder="Write reason for leave...">{{ old('reason') }}</textarea>
                            @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-primary">
                            <i class="ph ph-paper-plane-tilt me-1"></i>
                            Submit Request
                        </button>

                        <a href="{{ route('student.leave-requests.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>Leave Guidelines</h5>
                    <p class="text-muted mb-3">Please provide accurate leave information.</p>

                    <ul class="text-muted mb-0">
                        <li>Select correct leave dates.</li>
                        <li>Mention your destination clearly.</li>
                        <li>Provide active contact number.</li>
                        <li>You will be notified after approval or rejection.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
