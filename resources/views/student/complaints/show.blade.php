@extends('layouts.app', ['title' => 'Complaint Detail'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Complaint Detail</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="220">Category</th><td>{{ $complaint->category }}</td></tr>
            <tr><th>Subject</th><td>{{ $complaint->subject }}</td></tr>
            <tr><th>Description</th><td>{{ $complaint->description }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}</td></tr>
            <tr><th>Manager Response</th><td>{{ $complaint->manager_response ?? '-' }}</td></tr>
            <tr><th>Submitted At</th><td>{{ $complaint->created_at->format('d M Y h:i A') }}</td></tr>
        </table>

        <a href="{{ route('student.complaints.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
