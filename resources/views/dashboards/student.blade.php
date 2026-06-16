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
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Outstanding Fees</h6>
                            <h3 class="text-white mb-0 f-w-300">Rs. {{ number_format($totalOutstanding, 2) }}</h3>
                            <p class="text-white-50 mb-0">Pending dues</p>
                        </div>
                        <i class="ph ph-money text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 text-white">Attendance Today</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $attendanceToday ? 'Marked' : 'Not Marked' }}</h3>
                            <p class="text-white-50 mb-0">Meal attendance</p>
                        </div>
                        <i class="ph ph-fingerprint text-white" style="font-size: 38px;"></i>
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
                            <h3 class="text-white mb-0 f-w-300">{{ $pendingRequests }}</h3>
                            <p class="text-white-50 mb-0">Requests in process</p>
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
                            <h6 class="mb-2 text-white">Notifications</h6>
                            <h3 class="text-white mb-0 f-w-300">{{ $unreadNotifications }}</h3>
                            <p class="text-white-50 mb-0">Unread updates</p>
                        </div>
                        <i class="ph ph-bell text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
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
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Department</small>
                                <h6 class="mb-0 mt-1">{{ $student->department ?? '-' }}</h6>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Session</small>
                                <h6 class="mb-0 mt-1">{{ $student->session ?? '-' }}</h6>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Room</small>
                                <h6 class="mb-0 mt-1">{{ $student->room_no ?? 'Not allocated' }}</h6>
                            </div>
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
                                <strong>Rs. {{ number_format($latestInvoice->total_amount - $latestInvoice->paid_amount, 2) }}</strong>
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
                            <div class="border rounded p-3">
                                <h4>{{ $pendingLeaveRequests }}</h4>
                                <small>Leave</small>
                            </div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4>{{ $pendingGatePasses }}</h4>
                                <small>Gate Pass</small>
                            </div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4>{{ $pendingGuestMeals }}</h4>
                                <small>Guest Meals</small>
                            </div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4>{{ $pendingMessOffs }}</h4>
                                <small>Mess Off</small>
                            </div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4>{{ $openComplaints }}</h4>
                                <small>Complaints</small>
                            </div>
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
                    <a href="{{ route('student.room.index') }}" class="btn btn-outline-primary w-100 mb-2">My Room</a>
                    <a href="{{ route('student.mess-menu.index') }}" class="btn btn-outline-success w-100 mb-2">Weekly Menu</a>
                    <a href="{{ route('student.attendance.index') }}" class="btn btn-outline-info w-100 mb-2">Attendance History</a>
                    <a href="{{ route('student.fees.index') }}" class="btn btn-outline-warning w-100 mb-2">My Fees</a>
                    <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary w-100">Notifications</a>
                </div>
            </div>
        </div>
    </div>
@endsection
