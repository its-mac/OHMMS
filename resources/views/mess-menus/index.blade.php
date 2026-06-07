@extends('layouts.app')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <h4 class="mb-0">Mess Menu</h4>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Daily Menu Listing</h5>
            <a href="{{ route('admin.mess-menus.create') }}" class="btn btn-primary">
                Create Menu
            </a>
        </div>

        <div class="card-body">
            <form method="GET" class="row mb-3">
                <div class="col-md-4">
                    <input type="date" name="menu_date" value="{{ request('menu_date') }}" class="form-control">
                </div>

                <div class="col-md-4">
                    <select name="meal_session_id" class="form-control">
                        <option value="">All Meal Sessions</option>
                        @foreach($mealSessions as $session)
                            <option value="{{ $session->id }}" @selected(request('meal_session_id') == $session->id)>
                                {{ $session->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-secondary">Filter</button>
                    <a href="{{ route('admin.mess-menus.index') }}" class="btn btn-light">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Meal Session</th>
                            <th>Menu Items</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messMenus as $menu)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($menu->menu_date)->format('d M Y') }}</td>
                                <td>{{ $menu->mealSession->name }}</td>
                                <td>{{ Str::limit($menu->menu_items, 80) }}</td>
                                <td>
                                    <a href="{{ route('admin.mess-menus.show', $menu) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('admin.mess-menus.edit', $menu) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('admin.mess-menus.destroy', $menu) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this menu?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No mess menu found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $messMenus->links() }}
        </div>
    </div>
</div>
@endsection
