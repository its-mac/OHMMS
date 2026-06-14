@extends('layouts.app', ['title' => 'Add Manager'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Add Manager</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.managers.store') }}">
            @csrf

            @include('managers.partials.form', ['manager' => null])

            <button class="btn btn-primary">Save Manager</button>
            <a href="{{ route('admin.managers.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
