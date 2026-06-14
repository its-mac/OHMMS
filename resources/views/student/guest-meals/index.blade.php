@extends('layouts.app', ['title' => 'Guest Meals'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Guest Meal Requests</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>My Requests</h5>
        <a href="{{ route('student.guest-meals.create') }}" class="btn btn-primary btn-sm">New Request</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Meal</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guestMeals as $guestMeal)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($guestMeal->meal_date)->format('d M Y') }}</td>
                        <td>{{ $guestMeal->mealSession->name ?? '-' }}</td>
                        <td>{{ $guestMeal->guest_count }}</td>
                        <td>{{ ucfirst($guestMeal->status) }}</td>
                        <td>
                            <a href="{{ route('student.guest-meals.show', $guestMeal) }}" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No guest meal requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $guestMeals->links() }}
    </div>
</div>
@endsection
