@extends('layouts.app', ['title' => 'Admin Analytics'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Admin Analytics Dashboard</h5>
            <small class="text-muted">Owner-level system, finance and governance analytics</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Total Revenue</h6>
                            <h3 class="text-white mb-0 f-w-300">Rs. {{ number_format($totalRevenue) }}</h3>
                            <p class="text-white-50 mb-0">Collected amount</p>
                        </div>
                        <i class="ph ph-currency-circle-dollar text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Total Students</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $totalStudents }}</h3>
                            <p class="text-white-50 mb-0">Registered residents</p>
                        </div>
                        <i class="ph ph-student text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Occupancy Rate</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $occupancyRate }}%</h3>
                            <p class="text-white-50 mb-0">{{ $occupiedBeds }} / {{ $totalBeds }} beds</p>
                        </div>
                        <i class="ph ph-bed text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Collection Rate</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $collectionRate }}%</h3>
                            <p class="text-white-50 mb-0">{{ $defaultersCount }} defaulters</p>
                        </div>
                        <i class="ph ph-chart-line-up text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>System Overview</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <h6>Bed Occupancy</h6>
                            <h3>{{ $occupancyRate }}%</h3>
                            <small class="text-muted">{{ $occupiedBeds }} occupied / {{ $totalBeds }} total beds</small>
                            <div class="progress mt-2" style="height: 7px;">
                                <div class="progress-bar bg-primary" style="width: {{ $occupancyRate }}%"></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <h6>Collection Rate</h6>
                            <h3>{{ $collectionRate }}%</h3>
                            <small class="text-muted">Revenue collected vs generated</small>
                            <div class="progress mt-2" style="height: 7px;">
                                <div class="progress-bar bg-success" style="width: {{ $collectionRate }}%"></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <h6>Vacant Beds</h6>
                            <h3>{{ $vacantBeds }}</h3>
                            <small class="text-muted">Available hostel capacity</small>
                            <div class="progress mt-2" style="height: 7px;">
                                <div class="progress-bar bg-warning"
                                    style="width: {{ $totalBeds > 0 ? round(($vacantBeds / $totalBeds) * 100, 1) : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6>Total Generated</h6>
                                <h4>Rs. {{ number_format($totalGenerated, 2) }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6>Total Revenue</h6>
                                <h4>Rs. {{ number_format($totalRevenue, 2) }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6>Outstanding</h6>
                                <h4>Rs. {{ number_format($outstandingAmount, 2) }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6>Defaulters</h6>
                                <h4>{{ $defaultersCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5>Governance Summary</h5>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Open Complaints</h6>
                            <small class="text-muted">Pending or in-progress</small>
                        </div>
                        <span class="badge bg-warning">{{ $openComplaints }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Resolved Complaints</h6>
                            <small class="text-muted">Successfully closed</small>
                        </div>
                        <span class="badge bg-success">{{ $resolvedComplaints }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Escalated Complaints</h6>
                            <small class="text-muted">Require owner attention</small>
                        </div>
                        <span class="badge bg-danger">{{ $escalatedComplaints }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-1">Total Managers</h6>
                            <small class="text-muted">Operational users</small>
                        </div>
                        <span class="badge bg-primary">{{ $totalManagers }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row mt-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>Monthly Revenue Trend</h5>
                </div>
                <div class="card-body">
                    <div id="adminRevenueChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5>Complaint Overview</h5>
                </div>
                <div class="card-body">
                    <div id="adminComplaintChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header">
                    <h5>Attendance Trend - Last 30 Days</h5>
                </div>
                <div class="card-body">
                    <div id="adminAttendanceChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card">
                <div class="card-header">
                    <h5>Hostel Occupancy</h5>
                </div>
                <div class="card-body">
                    <div id="adminHostelOccupancyChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new ApexCharts(document.querySelector("#adminRevenueChart"), {
            chart: {
                type: 'area',
                height: 320,
                toolbar: { show: false }
            },
            series: [{
                name: 'Revenue',
                data: @json($revenueTrendData)
            }],
            xaxis: {
                categories: @json($revenueTrendLabels)
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return 'Rs. ' + value.toLocaleString();
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return 'Rs. ' + value.toLocaleString();
                    }
                }
            }
        }).render();

        new ApexCharts(document.querySelector("#adminComplaintChart"), {
            chart: {
                type: 'donut',
                height: 320
            },
            labels: @json($complaintChartLabels),
            series: @json($complaintChartData),
            legend: {
                position: 'bottom'
            }
        }).render();

        new ApexCharts(document.querySelector("#adminAttendanceChart"), {
            chart: {
                type: 'line',
                height: 320,
                toolbar: { show: false }
            },
            series: [{
                name: 'Attendance',
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

        new ApexCharts(document.querySelector("#adminHostelOccupancyChart"), {
            chart: {
                type: 'bar',
                height: 320,
                toolbar: { show: false }
            },
            series: [
                {
                    name: 'Capacity',
                    data: @json($hostelOccupancyCapacity)
                },
                {
                    name: 'Occupied',
                    data: @json($hostelOccupancyOccupied)
                }
            ],
            xaxis: {
                categories: @json($hostelOccupancyLabels)
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '45%'
                }
            },
            dataLabels: { enabled: false }
        }).render();
    });
</script>
@endpush
