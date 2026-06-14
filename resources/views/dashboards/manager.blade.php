@extends('layouts.app', ['title' => 'Manager Dashboard'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Manager Dashboard</h5>
        <small class="text-muted">Daily hostel and mess operations overview</small>
    </div>
</div>

<div class="row">

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Today's Attendance</h6>
                <h3>{{ $todayAttendance }}</h3>
                <a href="{{ route('manager.attendance.today') }}" class="btn btn-sm btn-light mt-2">View Today</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending Guest Meals</h6>
                <h3>{{ $pendingGuestMeals }}</h3>
                <a href="{{ route('manager.guest-meals.index') }}" class="btn btn-sm btn-light mt-2">Review</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending Mess Offs</h6>
                <h3>{{ $pendingMessOffs }}</h3>
                <a href="{{ route('manager.mess-offs.index') }}" class="btn btn-sm btn-light mt-2">Review</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Total Students</h6>
                <h3>{{ $totalStudents }}</h3>
                <span class="text-muted">Active records</span>
            </div>
        </div>
    </div>

</div>

<div class="row mt-3">

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending Leave Requests</h6>
                <h3>{{ $pendingLeaveRequests }}</h3>
                <a href="{{ route('manager.leave-requests.index') }}" class="btn btn-sm btn-light mt-2">Review</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending Gate Passes</h6>
                <h3>{{ $pendingGatePasses }}</h3>
                <a href="{{ route('manager.gate-passes.index') }}" class="btn btn-sm btn-light mt-2">Review</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Open Complaints</h6>
                <h3>{{ $openComplaints }}</h3>
                <a href="{{ route('manager.complaints.index') }}" class="btn btn-sm btn-light mt-2">Handle</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending Invoices</h6>
                <h3>{{ $pendingInvoices }}</h3>
                <a href="{{ route('manager.invoices.index') }}" class="btn btn-sm btn-light mt-2">View</a>
            </div>
        </div>
    </div>

</div>

<div class="row mt-3">

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Room Occupancy</h6>
                <h3>{{ $occupiedRooms }} / {{ $totalRooms }}</h3>
                <p class="mb-1">Vacant Rooms: {{ $vacantRooms }}</p>
                <a href="{{ route('manager.room-allocations.index') }}" class="btn btn-sm btn-light mt-2">
                    Manage Rooms
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Today's Collection</h6>
                <h3>Rs. {{ number_format($todayCollection) }}</h3>
                <a href="{{ route('manager.invoices.index') }}" class="btn btn-sm btn-light mt-2">
                    View Payments
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Outstanding Amount</h6>
                <h3>Rs. {{ number_format($outstandingAmount) }}</h3>
                <a href="{{ route('manager.invoices.index') }}" class="btn btn-sm btn-light mt-2">
                    View Defaulters
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
