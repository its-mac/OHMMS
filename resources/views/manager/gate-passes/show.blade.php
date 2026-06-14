@extends('layouts.app', ['title' => 'Gate Pass Detail'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Gate Pass Detail</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="220">Student</th><td>{{ $gatePass->student->name ?? '-' }}</td></tr>
            <tr><th>Registration No</th><td>{{ $gatePass->student->registration_no ?? '-' }}</td></tr>
            <tr><th>Out Time</th><td>{{ $gatePass->out_time->format('d M Y h:i A') }}</td></tr>
            <tr><th>Expected Return Time</th><td>{{ $gatePass->expected_return_time->format('d M Y h:i A') }}</td></tr>
            <tr><th>Destination</th><td>{{ $gatePass->destination }}</td></tr>
            <tr><th>Purpose</th><td>{{ $gatePass->purpose }}</td></tr>
            <tr><th>Contact During Outing</th><td>{{ $gatePass->contact_during_outing ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($gatePass->status) }}</td></tr>
        </table>

        @if($gatePass->status === 'pending')
            <form method="POST" action="{{ route('manager.gate-passes.approve', $gatePass) }}" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-success">Approve</button>
            </form>

            <form method="POST" action="{{ route('manager.gate-passes.reject', $gatePass) }}" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-danger">Reject</button>
            </form>
        @endif

        <a href="{{ route('manager.gate-passes.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
