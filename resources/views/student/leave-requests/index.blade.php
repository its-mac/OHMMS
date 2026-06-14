@extends('layouts.app', ['title' => 'Leave Requests'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Leave Requests</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>My Leave Requests</h5>
        <a href="{{ route('student.leave-requests.create') }}" class="btn btn-primary btn-sm">Apply Leave</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaveRequests as $leaveRequest)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d M Y') }}</td>
                        <td>{{ $leaveRequest->destination ?? '-' }}</td>
                        <td>{{ ucfirst($leaveRequest->status) }}</td>
                        <td>
                            <a href="{{ route('student.leave-requests.show', $leaveRequest) }}" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No leave requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $leaveRequests->links() }}
    </div>
</div>
@endsection
