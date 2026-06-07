@extends('layouts.app', ['title' => 'Create Meal Session'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5>Create Meal Session</h5>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h5>Meal Session Information</h5>
    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.meal-sessions.store') }}">

            @csrf

            @include('meal-sessions.partials.form')

            <div class="text-end">

                <a href="{{ route('admin.meal-sessions.index') }}"
                   class="btn btn-light">
                    Cancel
                </a>

                <button class="btn btn-primary">
                    Save Session
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
