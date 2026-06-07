@extends('layouts.app', ['title' => 'Floor Details'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Floor Details</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ $floor->name }}</h5>

            <a href="{{ route('admin.floors.edit', $floor) }}" class="btn btn-primary btn-sm">
                Edit Floor
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="220">Hostel</th>
                    <td>{{ $floor->block?->hostel?->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Block</th>
                    <td>{{ $floor->block?->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Floor Name</th>
                    <td>{{ $floor->name }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($floor->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
            </table>

            <a href="{{ route('admin.floors.index') }}" class="btn btn-light">
                Back
            </a>
        </div>
    </div>
@endsection
