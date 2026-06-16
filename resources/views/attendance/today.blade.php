@extends('layouts.app', ['title' => 'Today Attendance'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Today's Attendance</h5>
            <small class="text-muted">Meal attendance records for {{ now()->format('d M Y') }}</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Total Attendance" :value="$totalToday" subtitle="All meals today" icon="ph ph-fingerprint" color="primary" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Breakfast" :value="$breakfastCount" subtitle="Breakfast records" icon="ph ph-coffee" color="success" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Lunch" :value="$lunchCount" subtitle="Lunch records" icon="ph ph-bowl-food" color="warning" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Dinner" :value="$dinnerCount" subtitle="Dinner records" icon="ph ph-fork-knife" color="info" />
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Attendance Trend - Last 7 Days</h5>
                </div>
                <div class="card-body">
                    <div id="managerTodayTrendChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Meal Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="managerMealChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Attendance Records</h5>
                <small class="text-muted">Today's student meal attendance records</small>
            </div>

            <a href="{{ route('manager.attendance.scan') }}" class="btn btn-primary btn-sm">
                <i class="ph ph-fingerprint me-1"></i>
                Scan Attendance
            </a>
        </div>

        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Time</th>
                            <th>Reg No</th>
                            <th>Student</th>
                            <th>Meal Session</th>
                            <th>Method</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->attendance_time)->format('h:i A') }}</td>
                                <td>{{ $log->student->registration_no ?? '-' }}</td>
                                <td>{{ $log->student->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $log->mealSession->name ?? '-' }}
                                    </span>
                                </td>
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
                                <td colspan="6">
                                    <x-empty-state
                                        icon="ph ph-fingerprint"
                                        title="No attendance recorded today"
                                        message="Start scanner to mark meal attendance."
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new ApexCharts(document.querySelector("#managerTodayTrendChart"), {
            chart: {
                type: 'area',
                height: 320,
                toolbar: { show: false }
            },
            series: [{
                name: 'Attendance',
                data: @json($trendData)
            }],
            xaxis: {
                categories: @json($trendLabels)
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            }
        }).render();

        new ApexCharts(document.querySelector("#managerMealChart"), {
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
