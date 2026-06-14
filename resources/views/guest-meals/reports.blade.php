@extends('layouts.app', ['title' => 'Guest Meal Reports'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Guest Meal Reports</h5>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card"><div class="card-body">
            <h6>Total Approved Requests</h6>
            <h3>{{ $totalRequests }}</h3>
        </div></div>
    </div>

    <div class="col-md-6">
        <div class="card"><div class="card-body">
            <h6>Total Guest Meals</h6>
            <h3>{{ $totalGuests }}</h3>
        </div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Filter Report</h5>
    </div>

    <div class="card-body">
        <form method="GET" class="row">
            <div class="col-md-3 mb-3">
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
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
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.guest-meals.reports') }}" class="btn btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Approved Guest Meals</h5>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No approved guest meals found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $guestMeals->links() }}
    </div>
</div>
@endsection
