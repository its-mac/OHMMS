@extends('layouts.app', ['title' => 'Manager Dashboard'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Manager Dashboard</h5>
    </div>
</div>

<div class="row">

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Today's Attendance</h6>
                <h3>{{ $todayAttendance }}</h3>
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

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending Mess Offs</h6>
                <h3>{{ $pendingMessOffs }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Total Students</h6>
                <h3>{{ $totalStudents }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection
