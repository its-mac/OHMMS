@extends('layouts.app', ['title' => 'Allocate Room'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Allocate Room</h5>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Room Allocation Information</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.room-allocations.store') }}">
            @csrf

            @include('room-allocations.partials.form', [
                'allocation' => null,
                'students' => $students,
                'rooms' => $rooms
            ])

            <div class="text-end mt-4">
                <a href="{{ route('admin.room-allocations.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">Allocate Room</button>
            </div>
        </form>
    </div>
</div>
@endsection
