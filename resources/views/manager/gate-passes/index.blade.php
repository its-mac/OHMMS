@extends('layouts.app', ['title' => 'Gate Passes'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Gate Passes</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Filter Gate Passes</h5>
    </div>

    <div class="card-body">
        <form method="GET" class="row">
            <div class="col-md-4 mb-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['pending', 'approved', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('manager.gate-passes.index') }}" class="btn btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>All Gate Pass Requests</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Reg No</th>
                    <th>Out Time</th>
                    <th>Expected Return</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th width="210">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gatePasses as $gatePass)
                    <tr>
                        <td>{{ $gatePass->student->name ?? '-' }}</td>
                        <td>{{ $gatePass->student->registration_no ?? '-' }}</td>
                        <td>{{ $gatePass->out_time->format('d M Y h:i A') }}</td>
                        <td>{{ $gatePass->expected_return_time->format('d M Y h:i A') }}</td>
                        <td>{{ $gatePass->destination }}</td>
                        <td>{{ ucfirst($gatePass->status) }}</td>
                        <td>
                            <a href="{{ route('manager.gate-passes.show', $gatePass) }}" class="btn btn-info btn-sm">View</a>

                            @if($gatePass->status === 'pending')
                                <form method="POST" action="{{ route('manager.gate-passes.approve', $gatePass) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form method="POST" action="{{ route('manager.gate-passes.reject', $gatePass) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No gate pass requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $gatePasses->links() }}
    </div>
</div>
@endsection
