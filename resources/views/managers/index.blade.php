@extends('layouts.app', ['title' => 'Managers'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Managers</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Manager Accounts</h5>
        <a href="{{ route('admin.managers.create') }}" class="btn btn-primary btn-sm">
            Add Manager
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="160">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($managers as $manager)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $manager->name }}</td>
                        <td>{{ $manager->email }}</td>
                        <td>{{ ucfirst($manager->role) }}</td>
                        <td>
                            <a href="{{ route('admin.managers.edit', $manager) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.managers.destroy', $manager) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this manager?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No managers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $managers->links() }}
    </div>
</div>
@endsection
