@extends('layouts.app', ['title' => 'Apply Mess Off'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Apply Mess Off</h5>
            <small class="text-muted">Submit a request to temporarily stop mess meal service</small>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Mess Off Request Form</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('student.mess-offs.store') }}">
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
                            <label class="form-label">Reason</label>
                            <textarea name="reason" rows="5"
                                class="form-control @error('reason') is-invalid @enderror"
                                placeholder="Write reason for mess off request...">{{ old('reason') }}</textarea>
                            @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-primary">
                            <i class="ph ph-paper-plane-tilt me-1"></i>
                            Submit Request
                        </button>

                        <a href="{{ route('student.mess-offs.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>Mess Off Guidelines</h5>
                    <p class="text-muted mb-3">Please submit mess off requests before the selected dates.</p>

                    <ul class="text-muted mb-0">
                        <li>Select correct start and end dates.</li>
                        <li>Mess off requires manager approval.</li>
                        <li>Meals may continue until approval.</li>
                        <li>You will be notified after approval or rejection.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
