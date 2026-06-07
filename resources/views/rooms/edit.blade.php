@extends('layouts.app', ['title' => 'Edit Room'])

@section('content')
<div class="card">
    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.rooms.update', $room) }}">
            @csrf
            @method('PUT')

            @include('rooms.partials.form')

            <div class="text-end mt-4">
                <button class="btn btn-primary">
                    Save Room
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
