@extends('layouts.app')

@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <h4 class="mb-0">Edit Mess Menu</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('manager.mess-menus.update', $messMenu) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('mess-menus.partials.form')

                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('manager.mess-menus.index') }}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
