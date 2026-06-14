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
    <div class="card-header">
        <h5>Filter Complaints</h5>
    </div>

    <div class="card-body">
        <form method="GET" class="row">
            <div class="col-md-4 mb-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['pending', 'in_progress', 'resolved', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach(['Room', 'Mess', 'Water', 'Electricity', 'Internet', 'Cleanliness', 'Security', 'Other'] as $category)
                        <option value="{{ $category }}" @selected(request('category') === $category)>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('manager.complaints.index') }}" class="btn btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>All Complaints</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Reg No</th>
                    <th>Category</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->student->name ?? '-' }}</td>
                        <td>{{ $complaint->student->registration_no ?? '-' }}</td>
                        <td>{{ $complaint->category }}</td>
                        <td>{{ $complaint->subject }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}</td>
                        <td>
                            <a href="{{ route('manager.complaints.show', $complaint) }}" class="btn btn-info btn-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No complaints found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $complaints->links() }}
    </div>
</div>
@endsection
