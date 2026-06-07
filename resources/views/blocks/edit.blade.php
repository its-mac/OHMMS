@extends('layouts.app', ['title' => 'Edit Block'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Edit Block</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Update Block Information</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.blocks.update', $block) }}">
                @csrf
                @method('PUT')

                @include('blocks.partials.form', ['block' => $block, 'hostels' => $hostels])

                <div class="text-end mt-4">
                    <a href="{{ route('admin.blocks.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Block</button>
                </div>
            </form>
        </div>
    </div>
@endsection
