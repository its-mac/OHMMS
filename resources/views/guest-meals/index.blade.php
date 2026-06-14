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
    <div class="card-header">
        <h5>Filter Requests</h5>
    </div>

    <div class="card-body">
        <form method="GET" class="row">
            <div class="col-md-3 mb-3">
                <input type="date" name="meal_date" value="{{ request('meal_date') }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <select name="meal_session_id" class="form-select">
                    <option value="">All Meals</option>
                    @foreach($mealSessions as $session)
                        <option value="{{ $session->id }}" @selected(request('meal_session_id') == $session->id)>
                            {{ $session->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['pending', 'approved', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.guest-meals.index') }}" class="btn btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>All Guest Meal Requests</h5>
        <a href="{{ route('admin.guest-meals.reports') }}" class="btn btn-secondary btn-sm">Reports</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Reg No</th>
                    <th>Date</th>
                    <th>Meal</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th width="210">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guestMeals as $guestMeal)
                    <tr>
                        <td>{{ $guestMeal->student->name ?? '-' }}</td>
                        <td>{{ $guestMeal->student->registration_no ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($guestMeal->meal_date)->format('d M Y') }}</td>
                        <td>{{ $guestMeal->mealSession->name ?? '-' }}</td>
                        <td>{{ $guestMeal->guest_count }}</td>
                        <td>{{ ucfirst($guestMeal->status) }}</td>
                        <td>
                            <a href="{{ route('admin.guest-meals.show', $guestMeal) }}" class="btn btn-info btn-sm">View</a>

                            @if($guestMeal->status === 'pending')
                                <form method="POST" action="{{ route('admin.guest-meals.approve', $guestMeal) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form method="POST" action="{{ route('admin.guest-meals.reject', $guestMeal) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No guest meal requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $guestMeals->links() }}
    </div>
</div>
@endsection
