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
            <tr><th width="200">Student</th><td>{{ $messOff->student->name ?? '-' }}</td></tr>
            <tr><th>Registration No</th><td>{{ $messOff->student->registration_no ?? '-' }}</td></tr>
            <tr><th>From Date</th><td>{{ \Carbon\Carbon::parse($messOff->from_date)->format('d M Y') }}</td></tr>
            <tr><th>To Date</th><td>{{ \Carbon\Carbon::parse($messOff->to_date)->format('d M Y') }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($messOff->status) }}</td></tr>
            <tr><th>Reason</th><td>{{ $messOff->reason ?? '-' }}</td></tr>
        </table>

        @if($messOff->status === 'pending')
            <form method="POST" action="{{ route('manager.mess-offs.approve', $messOff) }}" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-success">Approve</button>
            </form>

            <form method="POST" action="{{ route('manager.mess-offs.reject', $messOff) }}" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-danger">Reject</button>
            </form>
        @endif

        <a href="{{ route('manager.mess-offs.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
