@extends('layouts.app', ['title' => 'Complaints'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Complaints</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>My Complaints</h5>
        <a href="{{ route('student.complaints.create') }}" class="btn btn-primary btn-sm">
            Submit Complaint
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->category }}</td>
                        <td>{{ $complaint->subject }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}</td>
                        <td>{{ $complaint->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('student.complaints.show', $complaint) }}" class="btn btn-info btn-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No complaints found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $complaints->links() }}
    </div>
</div>
@endsection
