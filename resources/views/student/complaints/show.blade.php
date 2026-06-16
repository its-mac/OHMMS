@extends('layouts.app', ['title' => 'Complaint Detail'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Complaint Detail</h5>
            <small class="text-muted">View complaint status, response and escalation details</small>
        </div>
    </div>

    @php
        $statusClass = match($complaint->status) {
            'resolved' => 'success',
            'rejected' => 'danger',
            'in_progress' => 'warning',
            default => 'secondary',
        };
    @endphp

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $complaint->subject }}</h5>
                        <small class="text-muted">Submitted on {{ $complaint->created_at->format('d M Y h:i A') }}</small>
                    </div>

                    <span class="badge bg-{{ $statusClass }}">
                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Category</small>
                                <h6 class="mb-0 mt-1">{{ $complaint->category }}</h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Escalation Status</small>
                                <br>
                                @if($complaint->is_escalated)
                                    <span class="badge bg-danger mt-2">Escalated to Admin</span>
                                @else
                                    <span class="badge bg-light text-muted mt-2">Not Escalated</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="border rounded p-3">
                                <small class="text-muted">Description</small>
                                <p class="mb-0 mt-1">{{ $complaint->description }}</p>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="border rounded p-3">
                                <small class="text-muted">Manager Response</small>
                                <p class="mb-0 mt-1">
                                    {{ $complaint->manager_response ?? 'No manager response yet.' }}
                                </p>
                            </div>
                        </div>

                        @if($complaint->is_escalated)
                            <div class="col-md-12 mb-3">
                                <div class="border rounded p-3 bg-warning bg-opacity-10">
                                    <small class="text-muted">Escalation Reason</small>
                                    <p class="mb-0 mt-1">
                                        {{ $complaint->escalation_reason ?? 'No escalation reason provided.' }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="border rounded p-3 bg-info bg-opacity-10">
                                    <small class="text-muted">Admin Response</small>
                                    <p class="mb-0 mt-1">
                                        {{ $complaint->admin_response ?? 'No admin response yet.' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('student.complaints.index') }}" class="btn btn-light">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Complaint Timeline</h5>
                </div>

                <div class="card-body">
                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="mb-1">Submitted</h6>
                        <small class="text-muted">{{ $complaint->created_at->format('d M Y h:i A') }}</small>
                    </div>

                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="mb-1">Current Status</h6>
                        <span class="badge bg-{{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </span>
                    </div>

                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="mb-1">Escalated</h6>

                        @if($complaint->is_escalated)
                            <span class="badge bg-danger">Yes</span>
                            <br>
                            <small class="text-muted">
                                {{ $complaint->escalated_at?->format('d M Y h:i A') }}
                            </small>
                        @else
                            <span class="badge bg-light text-muted">No</span>
                        @endif
                    </div>

                    <div>
                        <h6 class="mb-1">Admin Reviewed</h6>

                        @if($complaint->admin_reviewed_at)
                            <span class="badge bg-success">Reviewed</span>
                            <br>
                            <small class="text-muted">
                                {{ $complaint->admin_reviewed_at->format('d M Y h:i A') }}
                            </small>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
