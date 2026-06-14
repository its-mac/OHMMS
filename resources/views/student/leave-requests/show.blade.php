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
            <tr><th width="220">From Date</th><td>{{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d M Y') }}</td></tr>
            <tr><th>To Date</th><td>{{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d M Y') }}</td></tr>
            <tr><th>Destination</th><td>{{ $leaveRequest->destination ?? '-' }}</td></tr>
            <tr><th>Contact During Leave</th><td>{{ $leaveRequest->contact_during_leave ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($leaveRequest->status) }}</td></tr>
            <tr><th>Reason</th><td>{{ $leaveRequest->reason }}</td></tr>
        </table>

        <a href="{{ route('student.leave-requests.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
