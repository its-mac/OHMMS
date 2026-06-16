@extends('layouts.app', ['title' => 'Complaints'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Complaints</h5>
            <small class="text-muted">Track your submitted hostel and mess complaints</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $totalComplaints = $complaints->total();
        $openCount = $complaints->whereIn('status', ['pending', 'in_progress'])->count();
        $resolvedCount = $complaints->where('status', 'resolved')->count();
        $escalatedCount = $complaints->where('is_escalated', true)->count();
    @endphp

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <h6 class="text-white mb-2">Total Complaints</h6>
                    <h3 class="text-white mb-0">{{ $totalComplaints }}</h3>
                    <p class="text-white-50 mb-0">Submitted complaints</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <h6 class="text-white mb-2">Open</h6>
                    <h3 class="text-white mb-0">{{ $openCount }}</h3>
                    <p class="text-white-50 mb-0">Pending or in-progress</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-success">
                <div class="card-body">
                    <h6 class="text-white mb-2">Resolved</h6>
                    <h3 class="text-white mb-0">{{ $resolvedCount }}</h3>
                    <p class="text-white-50 mb-0">Closed complaints</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-info">
                <div class="card-body">
                    <h6 class="text-white mb-2">Escalated</h6>
                    <h3 class="text-white mb-0">{{ $escalatedCount }}</h3>
                    <p class="text-white-50 mb-0">Sent to admin</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">My Complaints</h5>
                <small class="text-muted">Latest complaint activity</small>
            </div>

            <a href="{{ route('student.complaints.create') }}" class="btn btn-primary btn-sm">
                <i class="ph ph-plus me-1"></i>
                Submit Complaint
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Escalation</th>
                            <th>Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($complaints as $complaint)
                            @php
                                $statusClass = match($complaint->status) {
                                    'resolved' => 'success',
                                    'rejected' => 'danger',
                                    'in_progress' => 'warning',
                                    default => 'secondary',
                                };
                            @endphp

                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $complaint->category }}
                                    </span>
                                </td>

                                <td>
                                    <strong>{{ $complaint->subject }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ Str::limit($complaint->description, 55) }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </td>

                                <td>
                                    @if($complaint->is_escalated)
                                        <span class="badge bg-danger">Escalated</span>
                                    @else
                                        <span class="badge bg-light text-muted">Normal</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $complaint->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $complaint->created_at->format('h:i A') }}</small>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('student.complaints.show', $complaint) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="ph ph-eye me-1"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="text-center py-5">
                                        <i class="ph ph-chat-circle-text text-muted d-block mb-2" style="font-size: 42px;"></i>
                                        <p class="text-muted mb-0">No complaints found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $complaints->links() }}
            </div>
        </div>
    </div>
@endsection
