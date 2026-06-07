@extends('layouts.app', ['title' => 'Edit Meal Session'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5>Edit Meal Session</h5>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h5>Update Meal Session</h5>
    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.meal-sessions.update', $mealSession) }}">

            @csrf
            @method('PUT')

            @include('meal-sessions.partials.form')

            <div class="text-end">

                <a href="{{ route('admin.meal-sessions.index') }}"
                   class="btn btn-light">
                    Cancel
                </a>

                <button class="btn btn-primary">
                    Update Session
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
