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
    <div class="card-header d-flex justify-content-between">
        <h5>My Gate Pass Requests</h5>
        <a href="{{ route('student.gate-passes.create') }}" class="btn btn-primary btn-sm">Apply Gate Pass</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Out Time</th>
                    <th>Expected Return</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gatePasses as $gatePass)
                    <tr>
                        <td>{{ $gatePass->out_time->format('d M Y h:i A') }}</td>
                        <td>{{ $gatePass->expected_return_time->format('d M Y h:i A') }}</td>
                        <td>{{ $gatePass->destination }}</td>
                        <td>{{ ucfirst($gatePass->status) }}</td>
                        <td>
                            <a href="{{ route('student.gate-passes.show', $gatePass) }}" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No gate pass requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $gatePasses->links() }}
    </div>
</div>
@endsection
