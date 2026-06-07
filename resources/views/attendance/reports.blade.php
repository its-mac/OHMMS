@extends('layouts.app', ['title' => 'Attendance Reports'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Attendance Reports</h5>
    </div>
</div>

<form method="GET" action="{{ route('admin.attendance.reports') }}" class="card mb-4">
    <div class="card-body">
        <div class="row align-items-end">
            <div class="col-md-4 mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ $date }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Meal Session</label>
                <select name="meal_session_id" class="form-select">
                    <option value="">All Sessions</option>
                    @foreach($mealSessions as $session)
                        <option value="{{ $session->id }}" {{ $mealSessionId == $session->id ? 'selected' : '' }}>
                            {{ $session->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <button class="btn btn-primary">
                    Generate Report
                </button>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-4">
        <div class="card bg-primary">
            <div class="card-body">
                <h6 class="text-white">Total Active Students</h6>
                <h3 class="text-white mb-0">{{ $totalStudents }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success">
            <div class="card-body">
                <h6 class="text-white">Present</h6>
                <h3 class="text-white mb-0">{{ $presentStudents }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-danger">
            <div class="card-body">
                <h6 class="text-white">Absent</h6>
                <h3 class="text-white mb-0">{{ $absentStudents }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5>Meal-wise Summary</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Meal Session</th>
                    <th>Total Attendance</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mealWiseCounts as $item)
                    <tr>
                        <td>{{ $item->mealSession?->name ?? '-' }}</td>
                        <td>{{ $item->total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-muted">No attendance found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5>Attendance Details</h5>
    </div>

    <div class="card-body table-border-style">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Reg No</th>
                        <th>Student</th>
                        <th>Meal</th>
                        <th>Method</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->attendance_time }}</td>
                            <td>{{ $log->student?->registration_no ?? '-' }}</td>
                            <td>{{ $log->student?->name ?? '-' }}</td>
                            <td>{{ $log->mealSession?->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($log->verification_method) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No records found for selected filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
