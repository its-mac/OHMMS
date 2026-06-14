@extends('layouts.app', ['title' => 'Mess Off Requests'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Mess Off Requests</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>My Mess Off Requests</h5>
        <a href="{{ route('student.mess-offs.create') }}" class="btn btn-primary btn-sm">Apply Mess Off</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messOffs as $messOff)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($messOff->from_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($messOff->to_date)->format('d M Y') }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($messOff->reason, 40) ?? '-' }}</td>
                        <td>{{ ucfirst($messOff->status) }}</td>
                        <td>
                            <a href="{{ route('student.mess-offs.show', $messOff) }}" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No mess off requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $messOffs->links() }}
    </div>
</div>
@endsection
