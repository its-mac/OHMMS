@extends('layouts.app', ['title' => 'Edit Fee Structure'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Edit Fee Structure</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.fee-structures.update', $feeStructure) }}">
            @csrf
            @method('PUT')

            @include('fee-structures.partials.form')

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.fee-structures.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
