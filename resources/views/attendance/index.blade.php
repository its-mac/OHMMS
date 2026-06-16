@extends('layouts.app', ['title' => 'Attendance Logs'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Attendance Logs</h5>
            <small class="text-muted">Search, filter and review all biometric attendance records</small>
        </div>
    </div>

    <div class="row">

        <div class="col-md-3">
            <x-kpi-card title="Filtered Records" :value="$filteredTotal" subtitle="Current filter result" icon="ph ph-list-checks"
                color="primary" />
        </div>

        <div class="col-md-3">
            <x-kpi-card title="Fingerprint" :value="$fingerprintTotal" subtitle="Biometric attendance" icon="ph ph-fingerprint"
                color="success" />
        </div>

        <div class="col-md-3">
            <x-kpi-card title="Manual" :value="$manualTotal" subtitle="Manual entries" icon="ph ph-pencil-simple"
                color="warning" />
        </div>

        <div class="col-md-3">
            <x-kpi-card title="Today's Attendance" :value="$todayAttendance" subtitle="$todayRate% attendance rate"
                icon="ph ph-calendar-check" color="info" />
        </div>

    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 class="mb-0">Attendance Trend</h5>
        </div>

        <div class="card-body">
            <div id="attendanceTrendChart" style="height:320px"></div>
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
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">To Date</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Meal Session</label>
                    <select name="meal_session_id" class="form-select">
                        <option value="">All Sessions</option>

                        @foreach ($mealSessions as $session)
                            <option value="{{ $session->id }}" @selected(request('meal_session_id') == $session->id)>
                                {{ $session->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Student</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Name or Registration No">
                </div>

                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <div>
                        <button class="btn btn-primary">
                            Filter
                        </button>

                        <a href="{{ route('manager.attendance.index') }}" class="btn btn-light">
                            Reset
                        </a>
                    </div>
                </div>

            </form>

        </div>

    </div>

    <div class="card mt-3">

        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Attendance Records</h5>
                <small class="text-muted">
                    Search, review and audit attendance activity
                </small>
            </div>

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
                                    @if ($log->verification_method == 'fingerprint')
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
                                    <x-empty-state icon="ph ph-fingerprint" title="No attendance records found"
                                        message="Try changing filters or scan new attendance." />
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

@push('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    new ApexCharts(
        document.querySelector("#attendanceTrendChart"),
        {
            chart:{
                type:'area',
                height:320,
                toolbar:{show:false}
            },

            series:[{
                name:'Attendance',
                data:@json($last7DaysData)
            }],

            xaxis:{
                categories:@json($last7DaysLabels)
            },

            dataLabels:{
                enabled:false
            },

            stroke:{
                curve:'smooth',
                width:3
            }
        }
    ).render();

});
</script>
@endpush
