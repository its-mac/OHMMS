@extends('layouts.app', ['title' => 'Add Fee Structure'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Add Fee Structure</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.fee-structures.store') }}">
            @csrf

            @include('fee-structures.partials.form', ['feeStructure' => null])

            <button class="btn btn-primary">Save</button>
            <a href="{{ route('admin.fee-structures.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
