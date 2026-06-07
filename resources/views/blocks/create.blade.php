@extends('layouts.app', ['title' => 'Add Block'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Add Block</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Block Information</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.blocks.store') }}">
                @csrf

                @include('blocks.partials.form', [
                    'block' => null,
                    'hostels' => $hostels
                ])

                <div class="text-end mt-4">
                    <a href="{{ route('admin.blocks.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Block</button>
                </div>
            </form>
        </div>
    </div>
@endsection
