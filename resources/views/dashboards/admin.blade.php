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
            <x-kpi-card title="Total Hostels" :value="$totalHostels" subtitle="Infrastructure units" icon="ph ph-buildings"
                color="primary" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Total Managers" :value="$totalManagers" subtitle="Operational staff" icon="ph ph-users-three"
                color="success" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Total Students" :value="$totalStudents" subtitle="Registered residents" icon="ph ph-student"
                color="warning" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Attendance Today" :value="$todayAttendance" subtitle="Meal attendance logs" icon="ph ph-fingerprint"
                color="info" />
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
                            <x-stat-box :value="'Rs. ' . number_format($totalGenerated, 2)" label="Total Generated" />
                        </div>

                        <div class="col-md-3">
                            <x-stat-box :value="'Rs. ' . number_format($totalRevenue, 2)" label="Total Revenue" />
                        </div>

                        <div class="col-md-3">
                            <x-stat-box :value="'Rs. ' . number_format($outstandingAmount, 2)" label="Outstanding" />
                        </div>

                        <div class="col-md-3">
                            <x-stat-box :value="$defaultersCount" label="Defaulters" />
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

                    <x-summary-row title="Escalated Complaints" subtitle="Require admin attention">
                        <span class="badge bg-danger">{{ $escalatedComplaints }}</span>
                    </x-summary-row>

                    <x-summary-row title="Complaints This Month" subtitle="All complaint activity">
                        <span class="badge bg-warning">{{ $complaintsThisMonth }}</span>
                    </x-summary-row>

                    <x-summary-row title="Paid Invoices" subtitle="Completed payments">
                        <span class="badge bg-success">{{ $paidInvoices }}</span>
                    </x-summary-row>

                    <x-summary-row title="Unpaid / Partial Invoices" subtitle="Pending receivables">
                        <span class="badge bg-danger">{{ $unpaidInvoices }}</span>
                    </x-summary-row>

                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        <div class="col-xl-8">
            <x-chart-card title="Monthly Revenue Trend" chart-id="monthly-revenue-chart" />
        </div>

        <div class="col-xl-4">
            <x-chart-card title="Complaint Status Summary" chart-id="complaint-status-chart" />
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
                            <x-action-button :href="route('admin.managers.index')" color="primary" icon="ph ph-users-three" class="p-3">
                                Manage Managers
                            </x-action-button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <x-action-button :href="route('admin.students.index')" color="success" icon="ph ph-student" class="p-3">
                                Manage Students
                            </x-action-button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <x-action-button :href="route('admin.fee-structures.index')" color="warning" icon="ph ph-money" class="p-3">
                                Fee Structures
                            </x-action-button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <x-action-button :href="route('admin.reports.analytics')" color="info" icon="ph ph-chart-bar" class="p-3">
                                Analytics Dashboard
                            </x-action-button>
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
