@extends('layouts.app', ['title' => 'Edit Floor'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Edit Floor</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Update Floor Information</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.floors.update', $floor) }}">
                @csrf
                @method('PUT')

                @include('floors.partials.form', [
                    'floor' => $floor,
                    'blocks' => $blocks
                ])

                <div class="text-end mt-4">
                    <a href="{{ route('admin.floors.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update Floor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
