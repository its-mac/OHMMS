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
    <div class="card-header">
        <h5>Filter Requests</h5>
    </div>

    <div class="card-body">
        <form method="GET" class="row">
            <div class="col-md-4 mb-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['pending', 'approved', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('manager.leave-requests.index') }}" class="btn btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>All Leave Requests</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Reg No</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th width="210">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaveRequests as $leaveRequest)
                    <tr>
                        <td>{{ $leaveRequest->student->name ?? '-' }}</td>
                        <td>{{ $leaveRequest->student->registration_no ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d M Y') }}</td>
                        <td>{{ $leaveRequest->destination ?? '-' }}</td>
                        <td>{{ ucfirst($leaveRequest->status) }}</td>
                        <td>
                            <a href="{{ route('manager.leave-requests.show', $leaveRequest) }}" class="btn btn-info btn-sm">View</a>

                            @if($leaveRequest->status === 'pending')
                                <form method="POST" action="{{ route('manager.leave-requests.approve', $leaveRequest) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form method="POST" action="{{ route('manager.leave-requests.reject', $leaveRequest) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No leave requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $leaveRequests->links() }}
    </div>
</div>
@endsection
