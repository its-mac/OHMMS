@extends('layouts.app', ['title' => 'Reports & Analytics'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Manager Reports & Analytics</h5>
            <small class="text-muted">Operational KPIs for hostel, mess, requests and finance</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card bg-primary">
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
            <div class="card bg-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Bed Occupancy</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $occupancyRate }}%</h3>
                            <p class="text-white-50 mb-0">{{ $occupiedBeds }} / {{ $totalBeds }} beds occupied</p>
                        </div>
                        <i class="ph ph-bed text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Attendance Today</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $attendanceRate }}%</h3>
                            <p class="text-white-50 mb-0">{{ $todayAttendance }} attendance records</p>
                        </div>
                        <i class="ph ph-fingerprint text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Outstanding</h6>
                            <h3 class="text-white mb-0 f-w-300">Rs. {{ number_format($outstandingAmount) }}</h3>
                            <p class="text-white-50 mb-0">{{ $defaultersCount }} defaulters</p>
                        </div>
                        <i class="ph ph-warning-circle text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>Operational Overview</h5>
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
                            <h6>Attendance Rate</h6>
                            <h3>{{ $attendanceRate }}%</h3>
                            <small class="text-muted">Today attendance coverage</small>
                            <div class="progress mt-2" style="height: 7px;">
                                <div class="progress-bar bg-warning" style="width: {{ $attendanceRate }}%"></div>
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
                                <h6>Vacant Beds</h6>
                                <h4>{{ $vacantBeds }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5>Pending Operations</h5>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Guest Meals</h6>
                            <small class="text-muted">Awaiting manager action</small>
                        </div>
                        <span class="badge bg-primary">{{ $pendingGuestMeals }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Mess Offs</h6>
                            <small class="text-muted">Awaiting approval</small>
                        </div>
                        <span class="badge bg-success">{{ $pendingMessOffs }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Leave Requests</h6>
                            <small class="text-muted">Student leave requests</small>
                        </div>
                        <span class="badge bg-warning">{{ $pendingLeaves }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-1">Gate Passes</h6>
                            <small class="text-muted">Gate movement requests</small>
                        </div>
                        <span class="badge bg-info">{{ $pendingGatePasses }}</span>
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
                    <h5>Attendance Trend - Last 7 Days</h5>
                </div>
                <div class="card-body">
                    <div id="managerAttendanceChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5>Request Summary</h5>
                </div>
                <div class="card-body">
                    <div id="managerRequestChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Complaint Summary</h5>
                </div>
                <div class="card-body">
                    <div id="managerComplaintChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Finance Summary</h5>
                </div>
                <div class="card-body">
                    <div id="managerFinanceChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new ApexCharts(document.querySelector("#managerAttendanceChart"), {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Attendance',
                    data: @json($attendanceTrendData)
                }],
                xaxis: {
                    categories: @json($attendanceTrendLabels)
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                }
            }).render();

            new ApexCharts(document.querySelector("#managerRequestChart"), {
                chart: {
                    type: 'donut',
                    height: 320
                },
                labels: @json($requestSummaryLabels),
                series: @json($requestSummaryData),
                legend: {
                    position: 'bottom'
                }
            }).render();

            new ApexCharts(document.querySelector("#managerComplaintChart"), {
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Complaints',
                    data: @json($complaintSummaryData)
                }],
                xaxis: {
                    categories: @json($complaintSummaryLabels)
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '45%'
                    }
                },
                dataLabels: {
                    enabled: false
                }
            }).render();

            new ApexCharts(document.querySelector("#managerFinanceChart"), {
                chart: {
                    type: 'donut',
                    height: 320
                },
                labels: @json($financeSummaryLabels),
                series: @json($financeSummaryData),
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return 'Rs. ' + value.toLocaleString();
                        }
                    }
                }
            }).render();
        });
    </script>
@endpush
