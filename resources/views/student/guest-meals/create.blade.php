@extends('layouts.app', ['title' => 'Request Guest Meal'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Request Guest Meal</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('student.guest-meals.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Meal Date</label>
                <input type="date" name="meal_date" value="{{ old('meal_date') }}"
                       class="form-control @error('meal_date') is-invalid @enderror">
                @error('meal_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
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

            <div class="mb-3">
                <label class="form-label">Guest Count</label>
                <input type="number" name="guest_count" min="1" max="10"
                       value="{{ old('guest_count', 1) }}"
                       class="form-control @error('guest_count') is-invalid @enderror">
                @error('guest_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" rows="3"
                          class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary">Submit Request</button>
            <a href="{{ route('student.guest-meals.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
