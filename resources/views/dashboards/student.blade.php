@extends('layouts.app', ['title' => 'Student Dashboard'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Student Dashboard</h5>
            <small class="text-muted">Your hostel, mess, fees and request overview</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Outstanding Fees" :value="'Rs. ' . number_format($totalOutstanding, 2)" subtitle="Pending dues" icon="ph ph-money" color="primary" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Attendance Today" :value="$attendanceToday ? 'Marked' : 'Not Marked'" subtitle="Meal attendance" icon="ph ph-fingerprint"
                color="success" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Pending Requests" :value="$pendingRequests" subtitle="Requests in process" icon="ph ph-hourglass"
                color="warning" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Notifications" :value="$unreadNotifications" subtitle="Unread updates" icon="ph ph-bell"
                color="info" />
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>My Hostel Profile</h5>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                            style="width: 58px; height: 58px;">
                            <i class="ph ph-student" style="font-size: 30px;"></i>
                        </div>

                        <div>
                            <h5 class="mb-1">{{ $student->name }}</h5>
                            <small class="text-muted">{{ $student->registration_no }}</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <x-info-box label="Department" :value="$student->department ?? '-'" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <x-info-box label="Session" :value="$student->session ?? '-'" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <x-info-box label="Room" :value="$student->room_no ?? 'Not allocated'" />
                        </div>
                    </div>

                    <div class="border rounded p-3">
                        <small class="text-muted">Account Status</small>
                        <br>
                        <span class="badge bg-success mt-2">{{ ucfirst($student->status) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5>Latest Fee Challan</h5>
                </div>

                <div class="card-body">
                    @if ($latestInvoice)
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-1">{{ $latestInvoice->invoice_no }}</h6>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::createFromDate($latestInvoice->year, $latestInvoice->month, 1)->format('F') }}
                                    {{ $latestInvoice->year }}
                                </small>
                            </div>

                            @if ($latestInvoice->status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif ($latestInvoice->status === 'partial')
                                <span class="badge bg-warning">Partial</span>
                            @else
                                <span class="badge bg-danger">Unpaid</span>
                            @endif
                        </div>

                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total</span>
                                <strong>Rs. {{ number_format($latestInvoice->total_amount, 2) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Paid</span>
                                <strong>Rs. {{ number_format($latestInvoice->paid_amount, 2) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Remaining</span>
                                <strong>Rs.
                                    {{ number_format($latestInvoice->total_amount - $latestInvoice->paid_amount, 2) }}</strong>
                            </div>
                        </div>

                        <a href="{{ route('student.fees.show', $latestInvoice) }}" class="btn btn-primary w-100">
                            View Challan
                        </a>
                    @else
                        <div class="text-center py-4">
                            <i class="ph ph-file-text text-muted d-block mb-2" style="font-size: 38px;"></i>
                            <p class="text-muted mb-0">No invoice generated yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>My Pending Requests</h5>
                </div>

                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-2 col-6 mb-3">
                            <x-stat-box :value="$pendingLeaveRequests" label="Leave" />
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <x-stat-box :value="$pendingGatePasses" label="Gate Pass" />
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <x-stat-box :value="$pendingGuestMeals" label="Guest Meals" />
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <x-stat-box :value="$pendingMessOffs" label="Mess Off" />
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <x-stat-box :value="$openComplaints" label="Complaints" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>

                <div class="card-body">
                    <x-action-button :href="route('student.room.index')" color="primary" class="mb-2">
                        My Room
                    </x-action-button>

                    <x-action-button :href="route('student.mess-menu.index')" color="success" class="mb-2">
                        Weekly Menu
                    </x-action-button>

                    <x-action-button :href="route('student.attendance.index')" color="info" class="mb-2">
                        Attendance History
                    </x-action-button>

                    <x-action-button :href="route('student.fees.index')" color="warning" class="mb-2">
                        My Fees
                    </x-action-button>

                    <x-action-button :href="route('notifications.index')" color="secondary">
                        Notifications
                    </x-action-button>
                </div>
            </div>
        </div>
    </div>
@endsection
