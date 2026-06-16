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
                            <div class="border rounded p-3 text-center h-100">
                                <i class="ph ph-users-three d-block mb-2 text-primary" style="font-size: 28px;"></i>
                                <h4>{{ $pendingGuestMeals }}</h4>
                                <small class="text-muted">Guest Meals</small>
                                <div class="mt-2">
                                    <a href="{{ route('manager.guest-meals.index') }}" class="btn btn-sm btn-light">
                                        Review
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <div class="border rounded p-3 text-center h-100">
                                <i class="ph ph-calendar-x d-block mb-2 text-warning" style="font-size: 28px;"></i>
                                <h4>{{ $pendingMessOffs }}</h4>
                                <small class="text-muted">Mess Offs</small>
                                <div class="mt-2">
                                    <a href="{{ route('manager.mess-offs.index') }}" class="btn btn-sm btn-light">
                                        Review
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <div class="border rounded p-3 text-center h-100">
                                <i class="ph ph-calendar-check d-block mb-2 text-success" style="font-size: 28px;"></i>
                                <h4>{{ $pendingLeaveRequests }}</h4>
                                <small class="text-muted">Leave Requests</small>
                                <div class="mt-2">
                                    <a href="{{ route('manager.leave-requests.index') }}" class="btn btn-sm btn-light">
                                        Review
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <div class="border rounded p-3 text-center h-100">
                                <i class="ph ph-door-open d-block mb-2 text-info" style="font-size: 28px;"></i>
                                <h4>{{ $pendingGatePasses }}</h4>
                                <small class="text-muted">Gate Passes</small>
                                <div class="mt-2">
                                    <a href="{{ route('manager.gate-passes.index') }}" class="btn btn-sm btn-light">
                                        Review
                                    </a>
                                </div>
                            </div>
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

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Today's Collection</h6>
                            <small class="text-muted">Payments received today</small>
                        </div>
                        <h5 class="mb-0">Rs. {{ number_format($todayCollection, 2) }}</h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Outstanding Amount</h6>
                            <small class="text-muted">Unpaid / partial dues</small>
                        </div>
                        <h5 class="mb-0">Rs. {{ number_format($outstandingAmount, 2) }}</h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Pending Invoices</h6>
                            <small class="text-muted">Require payment follow-up</small>
                        </div>
                        <span class="badge bg-danger">{{ $pendingInvoices }}</span>
                    </div>

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
            <div class="card">
                <div class="card-header">
                    <h5>7-Day Attendance Trend</h5>
                </div>

                <div class="card-body">
                    <div id="manager-attendance-chart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5>Pending Request Summary</h5>
                </div>

                <div class="card-body">
                    <div id="manager-request-chart" style="height: 320px;"></div>
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
                            <a href="{{ route('manager.attendance.scan') }}" class="btn btn-outline-primary w-100 p-3">
                                <i class="ph ph-fingerprint d-block mb-2" style="font-size: 28px;"></i>
                                Scan Attendance
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('manager.payment-proofs.index') }}"
                                class="btn btn-outline-success w-100 p-3">
                                <i class="ph ph-receipt d-block mb-2" style="font-size: 28px;"></i>
                                Verify Payments
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('manager.room-allocations.index') }}"
                                class="btn btn-outline-warning w-100 p-3">
                                <i class="ph ph-user-switch d-block mb-2" style="font-size: 28px;"></i>
                                Room Allocations
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('manager.reports.analytics') }}" class="btn btn-outline-info w-100 p-3">
                                <i class="ph ph-chart-bar d-block mb-2" style="font-size: 28px;"></i>
                                Reports & Analytics
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
    document.addEventListener('DOMContentLoaded', function () {
        new ApexCharts(document.querySelector("#manager-attendance-chart"), {
            chart: {
                type: 'area',
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
