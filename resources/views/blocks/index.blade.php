@extends('layouts.app', ['title' => 'Blocks'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Blocks</h5>
                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.blocks.create') }}" class="btn btn-primary">
                        <i class="ph ph-plus"></i> Add Block
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
            <h5>Block List</h5>
        </div>

        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Hostel</th>
                            <th>Block Name</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($blocks as $block)
                            <tr>
                                <td>{{ $block->hostel?->name ?? '-' }}</td>
                                <td>{{ $block->name }}</td>
                                <td>
                                    @if($block->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.blocks.show', $block) }}" class="btn btn-sm btn-light-primary">View</a>
                                    <a href="{{ route('admin.blocks.edit', $block) }}" class="btn btn-sm btn-light-warning">Edit</a>

                                    <form action="{{ route('admin.blocks.destroy', $block) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this block?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No blocks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $blocks->links() }}
            </div>
        </div>
    </div>
@endsection
