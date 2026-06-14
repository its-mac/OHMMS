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
            <tr><th width="220">Out Time</th><td>{{ $gatePass->out_time->format('d M Y h:i A') }}</td></tr>
            <tr><th>Expected Return Time</th><td>{{ $gatePass->expected_return_time->format('d M Y h:i A') }}</td></tr>
            <tr><th>Destination</th><td>{{ $gatePass->destination }}</td></tr>
            <tr><th>Purpose</th><td>{{ $gatePass->purpose }}</td></tr>
            <tr><th>Contact During Outing</th><td>{{ $gatePass->contact_during_outing ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($gatePass->status) }}</td></tr>
        </table>

        <a href="{{ route('student.gate-passes.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
