@extends('layouts.app', ['title' => 'Escalated Complaints'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Escalated Complaints</h5>
            <small class="text-muted">Complaints forwarded to admin for final review</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $totalEscalated = $complaints->total();
        $resolvedCount = $complaints->where('status', 'resolved')->count();
        $pendingReviewCount = $complaints->whereIn('status', ['pending', 'in_progress'])->count();
    @endphp

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white mb-2">Total Escalated</h6>
                            <h3 class="text-white mb-0">{{ $totalEscalated }}</h3>
                            <p class="text-white-50 mb-0">All escalated complaints</p>
                        </div>
                        <i class="ph ph-warning-octagon text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white mb-2">Pending Review</h6>
                            <h3 class="text-white mb-0">{{ $pendingReviewCount }}</h3>
                            <p class="text-white-50 mb-0">Need admin action</p>
                        </div>
                        <i class="ph ph-clock-countdown text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white mb-2">Resolved</h6>
                            <h3 class="text-white mb-0">{{ $resolvedCount }}</h3>
                            <p class="text-white-50 mb-0">Closed by admin</p>
                        </div>
                        <i class="ph ph-check-circle text-white" style="font-size: 38px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Complaints Escalated by Managers</h5>
                <small class="text-muted">Review, resolve or reject escalated student complaints</small>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Category</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Escalated At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($complaints as $complaint)
                            <tr>
                                <td>
                                    <span class="fw-semibold">#{{ $complaint->id }}</span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                                             style="width: 40px; height: 40px;">
                                            <i class="ph ph-student"></i>
                                        </div>

                                        <div>
                                            <h6 class="mb-0">{{ $complaint->student->name ?? '-' }}</h6>
                                            <small class="text-muted">
                                                {{ $complaint->student->registration_no ?? '' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $complaint->category }}
                                    </span>
                                </td>

                                <td>
                                    <strong>{{ $complaint->subject }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ Str::limit($complaint->escalation_reason, 45) }}
                                    </small>
                                </td>

                                <td>
                                    @php
                                        $statusClass = match($complaint->status) {
                                            'resolved' => 'success',
                                            'rejected' => 'danger',
                                            'in_progress' => 'warning',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </td>

                                <td>
                                    <span>{{ $complaint->escalated_at?->format('d M Y') }}</span>
                                    <br>
                                    <small class="text-muted">
                                        {{ $complaint->escalated_at?->format('h:i A') }}
                                    </small>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('admin.complaints.escalated.show', $complaint) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="ph ph-eye me-1"></i>
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-5">
                                        <i class="ph ph-check-circle text-success d-block mb-2" style="font-size: 42px;"></i>
                                        <h6>No escalated complaints found</h6>
                                        <p class="text-muted mb-0">All complaints are currently under control.</p>
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
