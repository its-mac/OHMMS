@extends('layouts.app', ['title' => 'Manager Dashboard'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Manager Dashboard</h5>
            <small class="text-muted">Daily hostel, mess, finance and student service operations</small>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6 col-xl-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Today's Attendance</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $todayAttendance }}</h3>
                            <p class="text-white-50 mb-0">Meal attendance logs</p>
                        </div>
                        <i class="ph ph-fingerprint text-white" style="font-size: 38px;"></i>
                    </div>

                    <a href="{{ route('manager.attendance.today') }}" class="btn btn-sm btn-light mt-3">
                        View Today
                    </a>
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
                            <p class="text-white-50 mb-0">Active student records</p>
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
                            <h6 class="mb-2 text-white">Pending Requests</h6>
                            <h3 class="text-white mb-0 f-w-300">
                                {{ $pendingGuestMeals + $pendingMessOffs + $pendingLeaveRequests + $pendingGatePasses }}
                            </h3>
                            <p class="text-white-50 mb-0">Awaiting action</p>
                        </div>
                        <i class="ph ph-hourglass text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Pending Invoices</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $pendingInvoices }}</h3>
                            <p class="text-white-50 mb-0">Unpaid / partial invoices</p>
                        </div>
                        <i class="ph ph-file-text text-white" style="font-size: 38px;"></i>
                    </div>

                    <a href="{{ route('manager.invoices.index') }}" class="btn btn-sm btn-light mt-3">
                        View Invoices
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>Operations Overview</h5>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3 col-6 mb-3">
                            <x-stat-box :value="$pendingGuestMeals" label="Guest Meals" icon="ph ph-users-three" color="primary"
                                :href="route('manager.guest-meals.index')" button="Review" />
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <x-stat-box :value="$pendingMessOffs" label="Mess Offs" icon="ph ph-calendar-x" color="warning"
                                :href="route('manager.mess-offs.index')" button="Review" />
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <x-stat-box :value="$pendingLeaveRequests" label="Leave Requests" icon="ph ph-calendar-check" color="success"
                                :href="route('manager.leave-requests.index')" button="Review" />
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <x-stat-box :value="$pendingGatePasses" label="Gate Passes" icon="ph ph-door-open" color="info"
                                :href="route('manager.gate-passes.index')" button="Review" />
                        </div>

                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <h6>Open Complaints</h6>
                            <h3>{{ $openComplaints }}</h3>
                            <small class="text-muted">Pending or in-progress complaints</small>
                            <div class="mt-2">
                                <a href="{{ route('manager.complaints.index') }}" class="btn btn-sm btn-outline-primary">
                                    Handle Complaints
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <h6>Room Occupancy</h6>
                            <h3>{{ $occupiedRooms }} / {{ $totalRooms }}</h3>
                            <small class="text-muted">Vacant Rooms: {{ $vacantRooms }}</small>
                            <div class="progress mt-2" style="height: 7px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0 }}%">
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('manager.room-allocations.index') }}"
                                    class="btn btn-sm btn-outline-success">
                                    Manage Rooms
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <h6>Mess Menu</h6>
                            <h3>Manage</h3>
                            <small class="text-muted">Update weekly mess menu</small>
                            <div class="mt-2">
                                <a href="{{ route('manager.mess-menus.index') }}" class="btn btn-sm btn-outline-warning">
                                    Open Menu
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5>Finance Snapshot</h5>
                </div>

                <div class="card-body">

                    <x-summary-row title="Today's Collection" subtitle="Payments received today">
                        <h5 class="mb-0">Rs. {{ number_format($todayCollection, 2) }}</h5>
                    </x-summary-row>

                    <x-summary-row title="Outstanding Amount" subtitle="Unpaid / partial dues">
                        <h5 class="mb-0">Rs. {{ number_format($outstandingAmount, 2) }}</h5>
                    </x-summary-row>

                    <x-summary-row title="Pending Invoices" subtitle="Require payment follow-up">
                        <span class="badge bg-danger">{{ $pendingInvoices }}</span>
                    </x-summary-row>

                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="{{ route('manager.invoices.index') }}" class="btn btn-outline-primary w-100">
                                Invoices
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('manager.finance-reports.defaulters') }}"
                                class="btn btn-outline-danger w-100">
                                Defaulters
                            </a>
                        </div>
                    </div>

                    <div class="mt-2">
                        <a href="{{ route('manager.invoices.generate-monthly') }}" class="btn btn-primary w-100">
                            Generate Monthly Fees
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        <div class="col-xl-8">
            <x-chart-card title="7-Day Attendance Trend" chart-id="manager-attendance-chart" />
        </div>

        <div class="col-xl-4">
            <x-chart-card title="Pending Request Summary" chart-id="manager-request-chart" />
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
                            <x-action-button :href="route('manager.attendance.scan')" color="primary" icon="ph ph-fingerprint" class="p-3">
                                Scan Attendance
                            </x-action-button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <x-action-button :href="route('manager.payment-proofs.index')" color="success" icon="ph ph-receipt" class="p-3">
                                Verify Payments
                            </x-action-button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <x-action-button :href="route('manager.room-allocations.index')" color="warning" icon="ph ph-user-switch" class="p-3">
                                Room Allocations
                            </x-action-button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <x-action-button :href="route('manager.reports.analytics')" color="info" icon="ph ph-chart-bar" class="p-3">
                                Reports & Analytics
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
            new ApexCharts(document.querySelector("#manager-attendance-chart"), {
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

            new ApexCharts(document.querySelector("#manager-request-chart"), {
                chart: {
                    type: 'donut',
                    height: 320
                },
                series: @json($requestSummaryData),
                labels: @json($requestSummaryLabels),
                legend: {
                    position: 'bottom'
                }
            }).render();
        });
    </script>
@endpush
