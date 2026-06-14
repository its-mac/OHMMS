@extends('layouts.app', ['title' => 'My Room'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">My Room</h5>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Current Room Allocation</h5>
    </div>

    <div class="card-body">
        @if($allocation)
            <table class="table table-bordered">
                <tr>
                    <th width="220">Hostel</th>
                    <td>{{ $allocation->room->floor->block->hostel->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Block</th>
                    <td>{{ $allocation->room->floor->block->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Floor</th>
                    <td>{{ $allocation->room->floor->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Room No</th>
                    <td>{{ $allocation->room->room_no ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Allocated Date</th>
                    <td>{{ optional($allocation->allocated_at)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($allocation->status) }}</td>
                </tr>
            </table>
        @else
            <div class="alert alert-warning mb-0">
                No active room allocation found.
            </div>
        @endif
    </div>
</div>
@endsection
