@extends('layouts.app', ['title' => 'Block Details'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Block Details</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ $block->name }}</h5>

            <a href="{{ route('admin.blocks.edit', $block) }}" class="btn btn-primary btn-sm">
                Edit Block
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="220">Hostel</th>
                    <td>{{ $block->hostel?->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Block Name</th>
                    <td>{{ $block->name }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($block->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
            </table>

            <a href="{{ route('admin.blocks.index') }}" class="btn btn-light">Back</a>
        </div>
    </div>
@endsection
