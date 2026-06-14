@extends('layouts.app')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <h4 class="mb-0">Student Dashboard</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Welcome, {{ auth()->user()->name }}</h5>

            @if($student)
                <p><strong>Registration No:</strong> {{ $student->registration_no }}</p>
                <p><strong>Department:</strong> {{ $student->department }}</p>
                <p><strong>Room:</strong> {{ $student->room_no }}</p>
            @else
                <div class="alert alert-warning">
                    Student profile is not linked with this login account.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
