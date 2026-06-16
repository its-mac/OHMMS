@extends('layouts.app', ['title' => 'Leave Detail'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Leave Detail</h5>
            <small class="text-muted">View your leave request status and details</small>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Leave Request</h5>
                        <small class="text-muted">
                            Submitted on {{ $leaveRequest->created_at->format('d M Y h:i A') }}
                        </small>
                    </div>

                    <x-status-badge :status="$leaveRequest->status" />
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">From Date</small>
                                <h6 class="mb-0 mt-1">
                                    {{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d M Y') }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">To Date</small>
                                <h6 class="mb-0 mt-1">
                                    {{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d M Y') }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Destination</small>
                                <h6 class="mb-0 mt-1">{{ $leaveRequest->destination ?? '-' }}</h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Contact During Leave</small>
                                <h6 class="mb-0 mt-1">{{ $leaveRequest->contact_during_leave ?? '-' }}</h6>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="border rounded p-3">
                                <small class="text-muted">Reason</small>
                                <p class="mb-0 mt-1">{{ $leaveRequest->reason }}</p>
                            </div>
                        </div>

                        @if(isset($leaveRequest->manager_response) || isset($leaveRequest->manager_remarks))
                            <div class="col-md-12 mb-3">
                                <div class="border rounded p-3 bg-info bg-opacity-10">
                                    <small class="text-muted">Manager Response</small>
                                    <p class="mb-0 mt-1">
                                        {{ $leaveRequest->manager_response ?? $leaveRequest->manager_remarks ?? 'No response yet.' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('student.leave-requests.index') }}" class="btn btn-light">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Request Timeline</h5>
                </div>

                <div class="card-body">
                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="mb-1">Submitted</h6>
                        <small class="text-muted">{{ $leaveRequest->created_at->format('d M Y h:i A') }}</small>
                    </div>

                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="mb-1">Current Status</h6>
                        <x-status-badge :status="$leaveRequest->status" />
                    </div>

                    <div>
                        <h6 class="mb-1">Last Updated</h6>
                        <small class="text-muted">{{ $leaveRequest->updated_at->format('d M Y h:i A') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
