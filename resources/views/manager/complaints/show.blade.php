@extends('layouts.app', ['title' => 'Complaint Detail'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Complaint Detail</h5>
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

<div class="card">
    <div class="card-header">
        <h5>Complaint Information</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="220">Student</th>
                <td>{{ $complaint->student->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Registration No</th>
                <td>{{ $complaint->student->registration_no ?? '-' }}</td>
            </tr>

            <tr>
                <th>Category</th>
                <td>{{ $complaint->category }}</td>
            </tr>

            <tr>
                <th>Subject</th>
                <td>{{ $complaint->subject }}</td>
            </tr>

            <tr>
                <th>Description</th>
                <td>{{ $complaint->description }}</td>
            </tr>

            <tr>
                <th>Current Status</th>
                <td>{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}</td>
            </tr>

            <tr>
                <th>Escalation</th>
                <td>
                    @if ($complaint->is_escalated)
                        <span class="badge bg-danger">Escalated to Admin</span>
                    @else
                        <span class="badge bg-secondary">Not Escalated</span>
                    @endif
                </td>
            </tr>

            @if ($complaint->is_escalated)
                <tr>
                    <th>Escalated At</th>
                    <td>{{ $complaint->escalated_at?->format('d M Y h:i A') ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Escalation Reason</th>
                    <td>{{ $complaint->escalation_reason ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Admin Response</th>
                    <td>{{ $complaint->admin_response ?? 'Not reviewed yet' }}</td>
                </tr>
            @endif

            <tr>
                <th>Submitted At</th>
                <td>{{ $complaint->created_at->format('d M Y h:i A') }}</td>
            </tr>
        </table>
    </div>
</div>

@if (!$complaint->is_escalated && !in_array($complaint->status, ['resolved', 'rejected']))
    <div class="card">
        <div class="card-header">
            <h5>Escalate Complaint to Admin</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('manager.complaints.escalate', $complaint) }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label">Escalation Reason</label>
                    <textarea name="escalation_reason"
                              rows="4"
                              class="form-control @error('escalation_reason') is-invalid @enderror"
                              placeholder="Explain why this complaint needs Admin attention...">{{ old('escalation_reason') }}</textarea>

                    @error('escalation_reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to escalate this complaint to Admin?')">
                    Escalate to Admin
                </button>
            </form>
        </div>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Update Complaint Status</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('manager.complaints.update-status', $complaint) }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="form-label">Status</label>

                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    @foreach(['pending', 'in_progress', 'resolved', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $complaint->status) === $status)>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>

                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Manager Response</label>

                <textarea name="manager_response"
                          rows="4"
                          class="form-control @error('manager_response') is-invalid @enderror">{{ old('manager_response', $complaint->manager_response) }}</textarea>

                @error('manager_response')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary">Update Status</button>

            <a href="{{ route('manager.complaints.index') }}" class="btn btn-light">
                Back
            </a>
        </form>
    </div>
</div>

@endsection
