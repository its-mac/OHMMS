@extends('layouts.app', ['title' => 'Add Floor'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Add Floor</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Floor Information</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.floors.store') }}">
                @csrf

                @include('floors.partials.form', [
                    'floor' => null,
                    'blocks' => $blocks
                ])

                <div class="text-end mt-4">
                    <a href="{{ route('admin.floors.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Floor</button>
                </div>
            </form>
        </div>
    </div>
@endsection
