@extends('layouts.app', ['title' => 'Add Room'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Add Room</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Room Information</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.rooms.store') }}">
                @csrf

                @include('rooms.partials.form', [
                    'room' => null,
                    'floors' => $floors
                ])

                <div class="text-end mt-4">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Room</button>
                </div>
            </form>
        </div>
    </div>
@endsection
