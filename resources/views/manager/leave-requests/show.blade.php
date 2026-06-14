@extends('layouts.app', ['title' => 'Leave Detail'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Leave Detail</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="220">Student</th><td>{{ $leaveRequest->student->name ?? '-' }}</td></tr>
            <tr><th>Registration No</th><td>{{ $leaveRequest->student->registration_no ?? '-' }}</td></tr>
            <tr><th>From Date</th><td>{{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d M Y') }}</td></tr>
            <tr><th>To Date</th><td>{{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d M Y') }}</td></tr>
            <tr><th>Destination</th><td>{{ $leaveRequest->destination ?? '-' }}</td></tr>
            <tr><th>Contact During Leave</th><td>{{ $leaveRequest->contact_during_leave ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($leaveRequest->status) }}</td></tr>
            <tr><th>Reason</th><td>{{ $leaveRequest->reason }}</td></tr>
        </table>

        @if($leaveRequest->status === 'pending')
            <form method="POST" action="{{ route('manager.leave-requests.approve', $leaveRequest) }}" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-success">Approve</button>
            </form>

            <form method="POST" action="{{ route('manager.leave-requests.reject', $leaveRequest) }}" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-danger">Reject</button>
            </form>
        @endif

        <a href="{{ route('manager.leave-requests.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
