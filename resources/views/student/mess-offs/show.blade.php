@extends('layouts.app', ['title' => 'Mess Off Detail'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Mess Off Detail</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="200">From Date</th><td>{{ \Carbon\Carbon::parse($messOff->from_date)->format('d M Y') }}</td></tr>
            <tr><th>To Date</th><td>{{ \Carbon\Carbon::parse($messOff->to_date)->format('d M Y') }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($messOff->status) }}</td></tr>
            <tr><th>Reason</th><td>{{ $messOff->reason ?? '-' }}</td></tr>
        </table>

        <a href="{{ route('student.mess-offs.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
