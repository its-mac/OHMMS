@extends('layouts.app', ['title' => 'Hostels'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Hostels</h5>
                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.hostels.create') }}" class="btn btn-primary">
                        <i class="ph ph-plus"></i> Add Hostel
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Hostel List</h5>
        </div>

        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($hostels as $hostel)
                            <tr>
                                <td>{{ $hostel->name }}</td>
                                <td class="text-capitalize">{{ $hostel->type }}</td>
                                <td>{{ $hostel->capacity }}</td>
                                <td>
                                    @if($hostel->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.hostels.show', $hostel) }}" class="btn btn-sm btn-light-primary">View</a>
                                    <a href="{{ route('admin.hostels.edit', $hostel) }}" class="btn btn-sm btn-light-warning">Edit</a>

                                    <form action="{{ route('admin.hostels.destroy', $hostel) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this hostel?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hostels found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $hostels->links() }}
            </div>
        </div>
    </div>
@endsection
