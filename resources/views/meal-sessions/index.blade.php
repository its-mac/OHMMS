@extends('layouts.app', ['title' => 'Meal Sessions'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">

            <div class="col-md-6">
                <h5 class="mb-0">Meal Sessions</h5>
            </div>

            <div class="col-md-6 text-end">
                <a href="{{ route('admin.meal-sessions.create') }}"
                   class="btn btn-primary">
                    <i class="ph ph-plus"></i>
                    Add Session
                </a>
            </div>

        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Meal Sessions List</h5>
    </div>

    <div class="card-body table-border-style">
        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($mealSessions as $mealSession)

                        <tr>

                            <td>{{ $mealSession->name }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($mealSession->start_time)->format('h:i A') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($mealSession->end_time)->format('h:i A') }}
                            </td>

                            <td>
                                @if($mealSession->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td class="text-end">

                                <a href="{{ route('admin.meal-sessions.show', $mealSession) }}"
                                   class="btn btn-sm btn-light-primary">
                                    View
                                </a>

                                <a href="{{ route('admin.meal-sessions.edit', $mealSession) }}"
                                   class="btn btn-sm btn-light-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.meal-sessions.destroy', $mealSession) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this meal session?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-light-danger">
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No meal sessions found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $mealSessions->links() }}
        </div>

    </div>
</div>

@endsection
