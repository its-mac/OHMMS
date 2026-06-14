@extends('layouts.app', ['title' => 'Edit Manager'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Edit Manager</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.managers.update', $manager) }}">
            @csrf
            @method('PUT')

            @include('managers.partials.form')

            <button class="btn btn-primary">Update Manager</button>
            <a href="{{ route('admin.managers.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
