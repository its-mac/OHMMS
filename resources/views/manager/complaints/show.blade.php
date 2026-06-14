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

<div class="card">
    <div class="card-header">
        <h5>Complaint Information</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="220">Student</th><td>{{ $complaint->student->name ?? '-' }}</td></tr>
            <tr><th>Registration No</th><td>{{ $complaint->student->registration_no ?? '-' }}</td></tr>
            <tr><th>Category</th><td>{{ $complaint->category }}</td></tr>
            <tr><th>Subject</th><td>{{ $complaint->subject }}</td></tr>
            <tr><th>Description</th><td>{{ $complaint->description }}</td></tr>
            <tr><th>Current Status</th><td>{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}</td></tr>
            <tr><th>Submitted At</th><td>{{ $complaint->created_at->format('d M Y h:i A') }}</td></tr>
        </table>
    </div>
</div>

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
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Manager Response</label>
                <textarea name="manager_response" rows="4"
                          class="form-control @error('manager_response') is-invalid @enderror">{{ old('manager_response', $complaint->manager_response) }}</textarea>
                @error('manager_response') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary">Update Status</button>
            <a href="{{ route('manager.complaints.index') }}" class="btn btn-light">Back</a>
        </form>
    </div>
</div>
@endsection
