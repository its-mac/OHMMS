@extends('layouts.app', ['title' => 'Attendance Logs'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Attendance Logs</h5>
        <small class="text-muted">Search, filter and review all biometric attendance records</small>
    </div>
</div>

<div class="row">

    <div class="col-md-4">
        <div class="card bg-primary">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white">Filtered Records</h6>
                        <h3 class="text-white mb-0">{{ $filteredTotal }}</h3>
                    </div>
                    <i class="ph ph-list-checks" style="font-size: 38px;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white">Fingerprint Records</h6>
                        <h3 class="text-white mb-0">{{ $fingerprintTotal }}</h3>
                    </div>
                    <i class="ph ph-fingerprint" style="font-size: 38px;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white">Manual Records</h6>
                        <h3 class="text-white mb-0">{{ $manualTotal }}</h3>
                    </div>
                    <i class="ph ph-pencil-simple" style="font-size: 38px;"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card mt-3">

    <div class="card-header">
        <h5 class="mb-0">Filter Attendance Logs</h5>
    </div>

    <div class="card-body">

        <form method="GET" class="row">

            <div class="col-md-2 mb-3">
                <label class="form-label">From Date</label>
                <input type="date"
                       name="from_date"
                       value="{{ request('from_date') }}"
                       class="form-control">
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label">To Date</label>
                <input type="date"
                       name="to_date"
                       value="{{ request('to_date') }}"
                       class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Meal Session</label>
                <select name="meal_session_id" class="form-select">
                    <option value="">All Sessions</option>

                    @foreach($mealSessions as $session)
                        <option value="{{ $session->id }}"
                            @selected(request('meal_session_id') == $session->id)>
                            {{ $session->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Student</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Name or Registration No">
            </div>

            <div class="col-md-2 mb-3 d-flex align-items-end">
                <div>
                    <button class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('manager.attendance.index') }}"
                       class="btn btn-light">
                        Reset
                    </a>
                </div>
            </div>

        </form>

    </div>

</div>

<div class="card mt-3">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Attendance Records</h5>

        <a href="{{ route('manager.attendance.scan') }}" class="btn btn-primary btn-sm">
            Scan Attendance
        </a>
    </div>

    <div class="card-body table-border-style">

        <div class="table-responsive">

            <table class="table table-hover table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Registration No</th>
                        <th>Student</th>
                        <th>Meal Session</th>
                        <th>Method</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr>
                            <td>{{ $logs->firstItem() + $loop->index }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($log->attendance_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($log->attendance_time)->format('h:i A') }}
                            </td>

                            <td>
                                {{ $log->student->registration_no ?? '-' }}
                            </td>

                            <td>
                                {{ $log->student->name ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $log->mealSession->name ?? '-' }}
                                </span>
                            </td>

                            <td>
                                @if($log->verification_method == 'fingerprint')
                                    <span class="badge bg-success">
                                        Fingerprint
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        Manual
                                    </span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                No attendance records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $logs->links() }}
        </div>

    </div>

</div>

@endsection
