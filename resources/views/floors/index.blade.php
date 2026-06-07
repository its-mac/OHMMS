@extends('layouts.app', ['title' => 'Floors'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Floors</h5>
                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.floors.create') }}" class="btn btn-primary">
                        <i class="ph ph-plus"></i> Add Floor
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
            <h5>Floor List</h5>
        </div>

        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Hostel</th>
                            <th>Block</th>
                            <th>Floor</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($floors as $floor)
                            <tr>
                                <td>{{ $floor->block?->hostel?->name ?? '-' }}</td>
                                <td>{{ $floor->block?->name ?? '-' }}</td>
                                <td>{{ $floor->name }}</td>
                                <td>
                                    @if($floor->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.floors.show', $floor) }}"
                                       class="btn btn-sm btn-light-primary">
                                        View
                                    </a>

                                    <a href="{{ route('admin.floors.edit', $floor) }}"
                                       class="btn btn-sm btn-light-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.floors.destroy', $floor) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this floor?')">
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
                                <td colspan="5" class="text-center text-muted">
                                    No floors found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $floors->links() }}
            </div>
        </div>
    </div>
@endsection
