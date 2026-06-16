@extends('layouts.app', ['title' => 'Gate Passes'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Gate Passes</h5>
            <small class="text-muted">Track your hostel outing requests</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $totalCount = $gatePasses->total();
        $pendingCount = $gatePasses->where('status', 'pending')->count();
        $approvedCount = $gatePasses->where('status', 'approved')->count();
        $rejectedCount = $gatePasses->where('status', 'rejected')->count();
    @endphp

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Total Requests" :value="$totalCount" subtitle="All gate passes" icon="ph ph-door-open" color="primary" />
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
                <h5 class="mb-0">My Gate Pass Requests</h5>
                <small class="text-muted">Latest outing request activity</small>
            </div>

            <a href="{{ route('student.gate-passes.create') }}" class="btn btn-primary btn-sm">
                <i class="ph ph-plus me-1"></i>
                Apply Gate Pass
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Outing Time</th>
                            <th>Destination</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Applied At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($gatePasses as $gatePass)
                            <tr>
                                <td>
                                    <strong>{{ $gatePass->out_time->format('d M Y h:i A') }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        Return: {{ $gatePass->expected_return_time->format('d M Y h:i A') }}
                                    </small>
                                </td>

                                <td>{{ $gatePass->destination }}</td>
                                <td>{{ $gatePass->purpose }}</td>

                                <td>
                                    <x-status-badge :status="$gatePass->status" />
                                </td>

                                <td>
                                    {{ $gatePass->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $gatePass->created_at->format('h:i A') }}</small>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('student.gate-passes.show', $gatePass) }}" class="btn btn-sm btn-primary">
                                        <i class="ph ph-eye me-1"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-empty-state
                                        icon="ph ph-door-open"
                                        title="No gate pass requests found"
                                        message="You have not submitted any gate pass request yet."
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $gatePasses->links() }}
            </div>
        </div>
    </div>
@endsection
