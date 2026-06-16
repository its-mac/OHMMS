@extends('layouts.app', ['title' => 'Request Guest Meal'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Request Guest Meal</h5>
            <small class="text-muted">Submit a meal request for your guest</small>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Guest Meal Request Form</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('student.guest-meals.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meal Date</label>
                                <input type="date" name="meal_date" value="{{ old('meal_date') }}"
                                    class="form-control @error('meal_date') is-invalid @enderror">
                                @error('meal_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meal Session</label>
                                <select name="meal_session_id" class="form-select @error('meal_session_id') is-invalid @enderror">
                                    <option value="">Select Meal Session</option>

                                    @foreach($mealSessions as $session)
                                        <option value="{{ $session->id }}" @selected(old('meal_session_id') == $session->id)>
                                            {{ $session->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('meal_session_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Guest Count</label>
                            <input type="number" name="guest_count" min="1" max="10"
                                value="{{ old('guest_count', 1) }}"
                                class="form-control @error('guest_count') is-invalid @enderror">
                            @error('guest_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="4"
                                class="form-control @error('remarks') is-invalid @enderror"
                                placeholder="Optional remarks for manager...">{{ old('remarks') }}</textarea>
                            @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-primary">
                            <i class="ph ph-paper-plane-tilt me-1"></i>
                            Submit Request
                        </button>

                        <a href="{{ route('student.guest-meals.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>Guest Meal Guidelines</h5>
                    <p class="text-muted mb-3">Please submit your request before the meal preparation time.</p>

                    <ul class="text-muted mb-0">
                        <li>Select correct meal date and session.</li>
                        <li>Guest count must be between 1 and 10.</li>
                        <li>Request approval is required before serving.</li>
                        <li>You will be notified after manager action.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
