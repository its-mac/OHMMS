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
    <div class="card-header">
        <h5>Filter Requests</h5>
    </div>

    <div class="card-body">
        <form method="GET" class="row">
            <div class="col-md-3 mb-3">
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['pending', 'approved', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('manager.mess-offs.index') }}" class="btn btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>All Mess Off Requests</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Reg No</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                    <th width="210">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messOffs as $messOff)
                    <tr>
                        <td>{{ $messOff->student->name ?? '-' }}</td>
                        <td>{{ $messOff->student->registration_no ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($messOff->from_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($messOff->to_date)->format('d M Y') }}</td>
                        <td>{{ ucfirst($messOff->status) }}</td>
                        <td>
                            <a href="{{ route('manager.mess-offs.show', $messOff) }}" class="btn btn-info btn-sm">View</a>

                            @if($messOff->status === 'pending')
                                <form method="POST" action="{{ route('manager.mess-offs.approve', $messOff) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form method="POST" action="{{ route('manager.mess-offs.reject', $messOff) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No mess off requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $messOffs->links() }}
    </div>
</div>
@endsection
