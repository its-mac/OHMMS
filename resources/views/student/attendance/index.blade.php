@extends('layouts.app', ['title' => 'Attendance History'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Attendance History</h5>
            <small class="text-muted">Track your meal attendance records and analytics</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Total Meals" :value="$totalMeals" subtitle="All recorded meals" icon="ph ph-fork-knife" color="primary" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="This Month" :value="$monthlyMeals" subtitle="Meals attended this month" icon="ph ph-calendar" color="success" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Today" :value="$todayMeals" subtitle="Meals attended today" icon="ph ph-clock" color="warning" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Monthly Rate" :value="$monthlyAttendancePercentage . '%'" subtitle="Estimated attendance rate" icon="ph ph-chart-pie-slice" color="info" />
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Attendance Trend - Last 30 Days</h5>
                </div>

                <div class="card-body">
                    <div id="studentAttendanceTrendChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Meal-wise Summary</h5>
                </div>

                <div class="card-body">
                    <div id="studentMealWiseChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 class="mb-0">Filter Attendance</h5>
        </div>

        <div class="card-body">
            <form method="GET" class="row align-items-end">
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
                        <option value="">All Sessions</option>

                        @foreach($mealSessions as $session)
                            <option value="{{ $session->id }}" @selected(request('meal_session_id') == $session->id)>
                                {{ $session->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <button class="btn btn-primary">
                        <i class="ph ph-funnel me-1"></i>
                        Filter
                    </button>

                    <a href="{{ route('student.attendance.index') }}" class="btn btn-light">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 class="mb-0">My Meal Attendance</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
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

                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($log->attendance_date)->format('d M Y') }}</strong>
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $log->mealSession->name ?? '-' }}
                                    </span>
                                </td>

                                <td>{{ \Carbon\Carbon::parse($log->attendance_time)->format('h:i A') }}</td>

                                <td>
                                    @if($log->verification_method === 'fingerprint')
                                        <span class="badge bg-success">Fingerprint</span>
                                    @else
                                        <span class="badge bg-warning">Manual</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <x-empty-state
                                        icon="ph ph-fingerprint"
                                        title="No attendance found"
                                        message="No attendance records match the selected filters."
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $attendanceLogs->links() }}
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new ApexCharts(document.querySelector("#studentAttendanceTrendChart"), {
            chart: {
                type: 'area',
                height: 320,
                toolbar: { show: false }
            },
            series: [{
                name: 'Meals Attended',
                data: @json($attendanceTrendData)
            }],
            xaxis: {
                categories: @json($attendanceTrendLabels)
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            }
        }).render();

        new ApexCharts(document.querySelector("#studentMealWiseChart"), {
            chart: {
                type: 'donut',
                height: 320
            },
            labels: @json($mealChartLabels),
            series: @json($mealChartData),
            legend: {
                position: 'bottom'
            }
        }).render();
    });
</script>
@endpush
