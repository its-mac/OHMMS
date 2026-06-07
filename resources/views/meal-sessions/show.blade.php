@extends('layouts.app', ['title' => 'Meal Session Details'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5>Meal Session Details</h5>
    </div>
</div>

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5>{{ $mealSession->name }}</h5>

        <a href="{{ route('admin.meal-sessions.edit', $mealSession) }}"
           class="btn btn-primary btn-sm">
            Edit Session
        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">Session Name</th>
                <td>{{ $mealSession->name }}</td>
            </tr>

            <tr>
                <th>Start Time</th>
                <td>
                    {{ \Carbon\Carbon::parse($mealSession->start_time)->format('h:i A') }}
                </td>
            </tr>

            <tr>
                <th>End Time</th>
                <td>
                    {{ \Carbon\Carbon::parse($mealSession->end_time)->format('h:i A') }}
                </td>
            </tr>

            <tr>
                <th>Status</th>
                <td>

                    @if($mealSession->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif

                </td>
            </tr>

            <tr>
                <th>Created</th>
                <td>{{ $mealSession->created_at }}</td>
            </tr>

        </table>

        <a href="{{ route('admin.meal-sessions.index') }}"
           class="btn btn-light">
            Back
        </a>

    </div>

</div>

@endsection
