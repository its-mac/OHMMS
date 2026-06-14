@extends('layouts.app', ['title' => 'Attendance History'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Attendance History</h5>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h6>Total Meals Taken</h6>
                <h3>{{ $totalMeals }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h6>This Month Meals</h6>
                <h3>{{ $monthlyMeals }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Filter Attendance</h5>
    </div>

    <div class="card-body">
        <form method="GET" class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Meal Session</label>
                <select name="meal_session_id" class="form-select">
                    <option value="">All</option>
                    @foreach($mealSessions as $session)
                        <option value="{{ $session->id }}" @selected(request('meal_session_id') == $session->id)>
                            {{ $session->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3 d-flex align-items-end">
                <button class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('student.attendance.index') }}" class="btn btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>My Meal Attendance</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Meal Session</th>
                        <th>Time</th>
                        <th>Verification Method</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceLogs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($log->attendance_date)->format('d M Y') }}</td>
                            <td>{{ $log->mealSession->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($log->attendance_time)->format('h:i A') }}</td>
                            <td>{{ ucfirst($log->verification_method) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No attendance found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $attendanceLogs->links() }}
    </div>
</div>
@endsection
