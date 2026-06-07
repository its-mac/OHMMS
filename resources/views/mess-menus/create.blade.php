@extends('layouts.app')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <h4 class="mb-0">Create Mess Menu</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.mess-menus.store') }}" method="POST">
                @csrf

                @include('mess-menus.partials.form')

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('admin.mess-menus.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
