@extends('layouts.app', ['title' => 'Room Allocation Details'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Room Allocation Details</h5>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>{{ $roomAllocation->student?->name }}</h5>

        <a href="{{ route('admin.room-allocations.edit', $roomAllocation) }}"
           class="btn btn-primary btn-sm">
            Edit Allocation
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="220">Student</th>
                <td>{{ $roomAllocation->student?->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Registration No</th>
                <td>{{ $roomAllocation->student?->registration_no ?? '-' }}</td>
            </tr>

            <tr>
                <th>Hostel</th>
                <td>{{ $roomAllocation->room?->floor?->block?->hostel?->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Block</th>
                <td>{{ $roomAllocation->room?->floor?->block?->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Floor</th>
                <td>{{ $roomAllocation->room?->floor?->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Room</th>
                <td>{{ $roomAllocation->room?->room_no ?? '-' }}</td>
            </tr>

            <tr>
                <th>Allocated Date</th>
                <td>{{ $roomAllocation->allocated_at?->format('d M Y') }}</td>
            </tr>

            <tr>
                <th>Released Date</th>
                <td>{{ $roomAllocation->released_at?->format('d M Y') ?? '-' }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    @if($roomAllocation->status === 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Released</span>
                    @endif
                </td>
            </tr>
        </table>

        <a href="{{ route('admin.room-allocations.index') }}" class="btn btn-light">
            Back
        </a>
    </div>
</div>
@endsection
