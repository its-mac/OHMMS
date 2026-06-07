@extends('layouts.app', ['title' => 'Edit Room Allocation'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Edit Room Allocation</h5>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Update Allocation</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.room-allocations.update', $roomAllocation) }}">
            @csrf
            @method('PUT')

            @include('room-allocations.partials.form', [
                'allocation' => $roomAllocation
            ])

            <div class="text-end mt-4">
                <a href="{{ route('admin.room-allocations.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Allocation</button>
            </div>
        </form>
    </div>
</div>
@endsection
