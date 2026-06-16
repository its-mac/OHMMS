@extends('layouts.app', ['title' => 'Mess Off Requests'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Mess Off Requests</h5>
            <small class="text-muted">Track your mess off applications and approval status</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $totalCount = $messOffs->total();
        $pendingCount = $messOffs->where('status', 'pending')->count();
        $approvedCount = $messOffs->where('status', 'approved')->count();
        $rejectedCount = $messOffs->where('status', 'rejected')->count();
    @endphp

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Total Requests" :value="$totalCount" subtitle="All mess off requests" icon="ph ph-calendar-x" color="primary" />
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
                <h5 class="mb-0">My Mess Off Requests</h5>
                <small class="text-muted">Latest mess off request activity</small>
            </div>

            <a href="{{ route('student.mess-offs.create') }}" class="btn btn-primary btn-sm">
                <i class="ph ph-plus me-1"></i>
                Apply Mess Off
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Applied At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($messOffs as $messOff)
                            <tr>
                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($messOff->from_date)->format('d M Y') }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        to {{ \Carbon\Carbon::parse($messOff->to_date)->format('d M Y') }}
                                    </small>
                                </td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($messOff->reason ?? 'No reason provided', 55) }}
                                </td>

                                <td>
                                    <x-status-badge :status="$messOff->status" />
                                </td>

                                <td>
                                    {{ $messOff->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $messOff->created_at->format('h:i A') }}</small>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('student.mess-offs.show', $messOff) }}" class="btn btn-sm btn-primary">
                                        <i class="ph ph-eye me-1"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <x-empty-state
                                        icon="ph ph-calendar-x"
                                        title="No mess off requests found"
                                        message="You have not submitted any mess off request yet."
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $messOffs->links() }}
            </div>
        </div>
    </div>
@endsection
