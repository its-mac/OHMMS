@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Admin Dashboard</h5>
        <small class="text-muted">
            Ownership, monitoring and financial overview
        </small>
    </div>
</div>

<div class="row">

    <div class="col-md-3">
        <div class="card bg-primary">
            <div class="card-body text-white">
                <h6>Total Hostels</h6>
                <h3>{{ $totalHostels }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success">
            <div class="card-body text-white">
                <h6>Total Managers</h6>
                <h3>{{ $totalManagers }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning">
            <div class="card-body text-white">
                <h6>Total Students</h6>
                <h3>{{ $totalStudents }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info">
            <div class="card-body text-white">
                <h6>Attendance Today</h6>
                <h3>{{ $todayAttendance }}</h3>
            </div>
        </div>
    </div>

</div>

<div class="row mt-3">

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Occupancy Rate</h6>
                <h3>{{ $occupancyPercentage }}%</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Total Revenue</h6>
                <h3>Rs. {{ number_format($totalRevenue) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Outstanding Amount</h6>
                <h3>Rs. {{ number_format($outstandingAmount) }}</h3>
            </div>
        </div>
    </div>

</div>

<div class="row mt-3">

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Open Complaints</h6>
                <h3>{{ $openComplaints }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending Leaves</h6>
                <h3>{{ $pendingLeaves }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending Gate Passes</h6>
                <h3>{{ $pendingGatePasses }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending Guest Meals</h6>
                <h3>{{ $pendingGuestMeals }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection
