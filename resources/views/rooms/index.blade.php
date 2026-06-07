@extends('layouts.app', ['title' => 'Rooms'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5>Rooms</h5>
            </div>

            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.rooms.create') }}"
                   class="btn btn-primary">
                    Add Room
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Hostel</th>
                    <th>Block</th>
                    <th>Floor</th>
                    <th>Room</th>
                    <th>Capacity</th>
                    <th>Occupied</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($rooms as $room)
                    <tr>
                        <td>{{ $room->floor->block->hostel->name }}</td>
                        <td>{{ $room->floor->block->name }}</td>
                        <td>{{ $room->floor->name }}</td>
                        <td>{{ $room->room_no }}</td>
                        <td>{{ $room->capacity }}</td>
                        <td>{{ $room->occupied }}</td>
                        <td>{{ ucfirst($room->status) }}</td>

                        <td class="text-end">
                            <a href="{{ route('admin.rooms.show',$room) }}"
                               class="btn btn-sm btn-light-primary">
                                View
                            </a>

                            <a href="{{ route('admin.rooms.edit',$room) }}"
                               class="btn btn-sm btn-light-warning">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $rooms->links() }}
    </div>
</div>
@endsection
