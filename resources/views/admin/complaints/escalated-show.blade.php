@extends('layouts.app', ['title' => 'Escalated Complaint'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Escalated Complaint Review</h5>
            <small class="text-muted">Review complaint details and submit admin decision</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                <div class="card-header">
                    <h5 class="mb-0">Complaint Details</h5>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                             style="width: 56px; height: 56px;">
                            <i class="ph ph-student" style="font-size: 28px;"></i>
                        </div>

                        <div>
                            <h5 class="mb-1">{{ $complaint->student->name ?? '-' }}</h5>
                            <small class="text-muted">
                                {{ $complaint->student->registration_no ?? '-' }}
                            </small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Category</small>
                                <h6 class="mb-0 mt-1">{{ $complaint->category }}</h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Current Status</small>
                                <br>
                                <span class="badge bg-{{ $statusClass }} mt-2">
                                    {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="border rounded p-3">
                                <small class="text-muted">Subject</small>
                                <h6 class="mb-0 mt-1">{{ $complaint->subject }}</h6>
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
                                    {{ $complaint->manager_response ?? 'No response provided.' }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="border rounded p-3 bg-warning bg-opacity-10">
                                <small class="text-muted">Escalation Reason</small>
                                <p class="mb-0 mt-1">
                                    {{ $complaint->escalation_reason }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Escalation Summary</h5>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Escalated At</h6>
                            <small class="text-muted">Forwarded to admin</small>
                        </div>
                        <div class="text-end">
                            <strong>{{ $complaint->escalated_at?->format('d M Y') }}</strong>
                            <br>
                            <small class="text-muted">{{ $complaint->escalated_at?->format('h:i A') }}</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">Admin Reviewed</h6>
                            <small class="text-muted">Review status</small>
                        </div>
                        <div class="text-end">
                            @if($complaint->admin_reviewed_at)
                                <strong>{{ $complaint->admin_reviewed_at->format('d M Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ $complaint->admin_reviewed_at->format('h:i A') }}</small>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h6 class="mb-1">Admin Response</h6>
                        <p class="text-muted mb-0">
                            {{ $complaint->admin_response ?? 'No admin response submitted yet.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Admin Review</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.complaints.escalated.review', $complaint) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="in_progress" @selected(old('status', $complaint->status) == 'in_progress')>
                                    In Progress
                                </option>

                                <option value="resolved" @selected(old('status', $complaint->status) == 'resolved')>
                                    Resolved
                                </option>

                                <option value="rejected" @selected(old('status', $complaint->status) == 'rejected')>
                                    Rejected
                                </option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Admin Response</label>

                            <textarea name="admin_response"
                                      rows="5"
                                      class="form-control @error('admin_response') is-invalid @enderror">{{ old('admin_response', $complaint->admin_response) }}</textarea>

                            @error('admin_response')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary w-100 mb-2">
                            <i class="ph ph-check-circle me-1"></i>
                            Submit Review
                        </button>

                        <a href="{{ route('admin.complaints.escalated') }}" class="btn btn-light w-100">
                            Back to List
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
