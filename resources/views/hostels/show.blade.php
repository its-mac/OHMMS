@extends('layouts.app', ['title' => 'Hostel Details'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Hostel Details</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ $hostel->name }}</h5>

            <a href="{{ route('admin.hostels.edit', $hostel) }}" class="btn btn-primary btn-sm">
                Edit Hostel
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="220">Name</th>
                    <td>{{ $hostel->name }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td class="text-capitalize">{{ $hostel->type }}</td>
                </tr>
                <tr>
                    <th>Capacity</th>
                    <td>{{ $hostel->capacity }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($hostel->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
            </table>

            <a href="{{ route('admin.hostels.index') }}" class="btn btn-light">Back</a>
        </div>
    </div>
@endsection
