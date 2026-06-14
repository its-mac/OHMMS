@extends('layouts.app', ['title' => 'My Profile'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">My Profile</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Profile Information</h5>
        <a href="{{ route('student.profile.edit') }}" class="btn btn-primary btn-sm">Edit Profile</a>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                @if($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" class="rounded border mb-3" width="150">
                @else
                    <div class="border rounded p-4 mb-3">No Photo</div>
                @endif
            </div>

            <div class="col-md-9">
                <table class="table table-bordered">
                    <tr><th>Registration No</th><td>{{ $student->registration_no }}</td></tr>
                    <tr><th>Name</th><td>{{ $student->name }}</td></tr>
                    <tr><th>Father Name</th><td>{{ $student->father_name ?? '-' }}</td></tr>
                    <tr><th>CNIC</th><td>{{ $student->cnic ?? '-' }}</td></tr>
                    <tr><th>Department</th><td>{{ $student->department ?? '-' }}</td></tr>
                    <tr><th>Session</th><td>{{ $student->session ?? '-' }}</td></tr>
                    <tr><th>Email</th><td>{{ $student->email }}</td></tr>
                    <tr><th>Phone</th><td>{{ $student->phone ?? '-' }}</td></tr>
                    <tr><th>Blood Group</th><td>{{ $student->blood_group ?? '-' }}</td></tr>
                    <tr><th>Guardian Name</th><td>{{ $student->guardian_name ?? '-' }}</td></tr>
                    <tr><th>Guardian Phone</th><td>{{ $student->guardian_phone ?? '-' }}</td></tr>
                    <tr><th>Emergency Contact</th><td>{{ $student->emergency_contact ?? '-' }}</td></tr>
                    <tr><th>Address</th><td>{{ $student->address ?? '-' }}</td></tr>
                    <tr><th>Status</th><td>{{ ucfirst($student->status) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
