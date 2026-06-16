@extends('layouts.app', ['title' => 'Leave Requests'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Leave Requests</h5>
            <small class="text-muted">Track your hostel leave applications</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $totalCount = $leaveRequests->total();
        $pendingCount = $leaveRequests->where('status', 'pending')->count();
        $approvedCount = $leaveRequests->where('status', 'approved')->count();
        $rejectedCount = $leaveRequests->where('status', 'rejected')->count();
    @endphp

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Total Requests" :value="$totalCount" subtitle="All leave applications" icon="ph ph-calendar" color="primary" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Pending" :value="$pendingCount" subtitle="Awaiting approval" icon="ph ph-hourglass" color="warning" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Approved" :value="$approvedCount" subtitle="Accepted requests" icon="ph ph-check-circle" color="success" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Rejected" :value="$rejectedCount" subtitle="Declined requests" icon="ph ph-x-circle" color="danger" />
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">My Leave Requests</h5>
                <small class="text-muted">Latest leave request activity</small>
            </div>

            <a href="{{ route('student.leave-requests.create') }}" class="btn btn-primary btn-sm">
                <i class="ph ph-plus me-1"></i>
                Apply Leave
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Duration</th>
                            <th>Destination</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Applied At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($leaveRequests as $leaveRequest)
                            <tr>
                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d M Y') }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        to {{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d M Y') }}
                                    </small>
                                </td>

                                <td>{{ $leaveRequest->destination ?? '-' }}</td>
                                <td>{{ $leaveRequest->contact_during_leave ?? '-' }}</td>

                                <td>
                                    <x-status-badge :status="$leaveRequest->status" />
                                </td>

                                <td>
                                    {{ $leaveRequest->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $leaveRequest->created_at->format('h:i A') }}</small>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('student.leave-requests.show', $leaveRequest) }}" class="btn btn-sm btn-primary">
                                        <i class="ph ph-eye me-1"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-empty-state
                                        icon="ph ph-calendar-x"
                                        title="No leave requests found"
                                        message="You have not submitted any leave request yet."
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $leaveRequests->links() }}
            </div>
        </div>
    </div>
@endsection
