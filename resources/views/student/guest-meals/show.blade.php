@extends('layouts.app', ['title' => 'Guest Meal Detail'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Guest Meal Detail</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="200">Meal Date</th><td>{{ \Carbon\Carbon::parse($guestMeal->meal_date)->format('d M Y') }}</td></tr>
            <tr><th>Meal Session</th><td>{{ $guestMeal->mealSession->name ?? '-' }}</td></tr>
            <tr><th>Guest Count</th><td>{{ $guestMeal->guest_count }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($guestMeal->status) }}</td></tr>
            <tr><th>Remarks</th><td>{{ $guestMeal->remarks ?? '-' }}</td></tr>
        </table>

        <a href="{{ route('student.guest-meals.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
