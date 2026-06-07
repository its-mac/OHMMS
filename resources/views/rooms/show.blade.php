@extends('layouts.app', ['title' => 'Room Details'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Room Details</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Room {{ $room->room_no }}</h5>

            <a href="{{ route('admin.rooms.edit', $room) }}"
               class="btn btn-primary btn-sm">
                Edit Room
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">

                <tr>
                    <th width="220">Hostel</th>
                    <td>{{ $room->floor?->block?->hostel?->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Block</th>
                    <td>{{ $room->floor?->block?->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Floor</th>
                    <td>{{ $room->floor?->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Room Number</th>
                    <td>{{ $room->room_no }}</td>
                </tr>

                <tr>
                    <th>Capacity</th>
                    <td>{{ $room->capacity }}</td>
                </tr>

                <tr>
                    <th>Occupied</th>
                    <td>{{ $room->occupied }}</td>
                </tr>

                <tr>
                    <th>Available Seats</th>
                    <td>{{ $room->capacity - $room->occupied }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @switch($room->status)
                            @case('available')
                                <span class="badge bg-success">Available</span>
                                @break

                            @case('full')
                                <span class="badge bg-danger">Full</span>
                                @break

                            @case('maintenance')
                                <span class="badge bg-warning">Maintenance</span>
                                @break

                            @default
                                <span class="badge bg-secondary">Inactive</span>
                        @endswitch
                    </td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td>{{ $room->created_at?->format('d M Y h:i A') }}</td>
                </tr>

                <tr>
                    <th>Last Updated</th>
                    <td>{{ $room->updated_at?->format('d M Y h:i A') }}</td>
                </tr>

            </table>

            <div class="mt-3">
                <a href="{{ route('admin.rooms.index') }}"
                   class="btn btn-light">
                    Back
                </a>

                <a href="{{ route('admin.rooms.edit', $room) }}"
                   class="btn btn-primary">
                    Edit Room
                </a>
            </div>
        </div>
    </div>
@endsection
