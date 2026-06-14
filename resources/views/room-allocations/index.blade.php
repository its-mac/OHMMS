@extends('layouts.app', ['title' => 'Room Allocations'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Room Allocations</h5>
                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('manager.room-allocations.create') }}" class="btn btn-primary">
                        <i class="ph ph-plus"></i> Allocate Room
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Allocation List</h5>
        </div>

        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Reg No</th>
                            <th>Room</th>
                            <th>Hostel</th>
                            <th>Allocated</th>
                            <th>Released</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($allocations as $allocation)
                            <tr>
                                <td>{{ $allocation->student?->name ?? '-' }}</td>
                                <td>{{ $allocation->student?->registration_no ?? '-' }}</td>
                                <td>{{ $allocation->room?->room_no ?? '-' }}</td>
                                <td>{{ $allocation->room?->floor?->block?->hostel?->name ?? '-' }}</td>
                                <td>{{ $allocation->allocated_at?->format('d M Y') }}</td>
                                <td>{{ $allocation->released_at?->format('d M Y') ?? '-' }}</td>
                                <td>
                                    @if ($allocation->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Released</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('manager.room-allocations.show', $allocation) }}"
                                        class="btn btn-sm btn-light-primary">View</a>

                                    <a href="{{ route('manager.room-allocations.edit', $allocation) }}"
                                        class="btn btn-sm btn-light-warning">Edit</a>

                                    <form action="{{ route('manager.room-allocations.destroy', $allocation) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this allocation?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-light-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No allocations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $allocations->links() }}
            </div>
        </div>
    </div>
@endsection
