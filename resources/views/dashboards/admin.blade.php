@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Admin Dashboard</h5>
            <small class="text-muted">Ownership, monitoring and financial overview</small>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6 col-xl-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Total Hostels</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $totalHostels }}</h3>
                            <p class="text-white-50 mb-0">Infrastructure units</p>
                        </div>
                        <i class="ph ph-buildings text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Total Managers</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $totalManagers }}</h3>
                            <p class="text-white-50 mb-0">Operational staff</p>
                        </div>
                        <i class="ph ph-users-three text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-warning">
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
            <div class="card bg-info">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Attendance Today</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $todayAttendance }}</h3>
                            <p class="text-white-50 mb-0">Meal attendance logs</p>
                        </div>
                        <i class="ph ph-fingerprint text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>Owner Overview</h5>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <h6>Bed Occupancy</h6>
                            <h3>{{ $occupancyPercentage }}%</h3>
                            <small class="text-muted">{{ $occupiedBeds }} occupied / {{ $totalBeds }} total beds</small>

                            <div class="progress mt-2" style="height: 7px;">
                                <div class="progress-bar bg-primary" style="width: {{ $occupancyPercentage }}%"></div>
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
                    <h5>Governance Alerts</h5>
                </div>

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Escalated Complaints</h6>
                            <small class="text-muted">Require admin attention</small>
                        </div>
                        <span class="badge bg-danger">{{ $escalatedComplaints }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Complaints This Month</h6>
                            <small class="text-muted">All complaint activity</small>
                        </div>
                        <span class="badge bg-warning">{{ $complaintsThisMonth }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Paid Invoices</h6>
                            <small class="text-muted">Completed payments</small>
                        </div>
                        <span class="badge bg-success">{{ $paidInvoices }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-1">Unpaid / Partial Invoices</h6>
                            <small class="text-muted">Pending receivables</small>
                        </div>
                        <span class="badge bg-danger">{{ $unpaidInvoices }}</span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>Monthly Revenue Trend</h5>
                </div>

                <div class="card-body">
                    <div id="monthly-revenue-chart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5>Complaint Status Summary</h5>
                </div>

                <div class="card-body">
                    <div id="complaint-status-chart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-3">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.managers.index') }}" class="btn btn-outline-primary w-100 p-3">
                                <i class="ph ph-users-three d-block mb-2" style="font-size: 28px;"></i>
                                Manage Managers
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-outline-success w-100 p-3">
                                <i class="ph ph-student d-block mb-2" style="font-size: 28px;"></i>
                                Manage Students
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.fee-structures.index') }}"
                                class="btn btn-outline-warning w-100 p-3">
                                <i class="ph ph-money d-block mb-2" style="font-size: 28px;"></i>
                                Fee Structures
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.reports.analytics') }}" class="btn btn-outline-info w-100 p-3">
                                <i class="ph ph-chart-bar d-block mb-2" style="font-size: 28px;"></i>
                                Analytics Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revenueOptions = {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Revenue',
                    data: @json($monthlyRevenueData)
                }],
                xaxis: {
                    categories: @json($monthlyRevenueLabels)
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return 'Rs. ' + value.toLocaleString();
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return 'Rs. ' + value.toLocaleString();
                        }
                    }
                }
            };

            new ApexCharts(
                document.querySelector("#monthly-revenue-chart"),
                revenueOptions
            ).render();

            const complaintOptions = {
                chart: {
                    type: 'donut',
                    height: 320
                },
                series: @json($complaintStatusData),
                labels: @json($complaintStatusLabels),
                legend: {
                    position: 'bottom'
                }
            };

            new ApexCharts(
                document.querySelector("#complaint-status-chart"),
                complaintOptions
            ).render();
        });
    </script>
@endpush
