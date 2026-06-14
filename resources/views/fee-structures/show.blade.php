@extends('layouts.app', ['title' => 'Fee Structure Detail'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Fee Structure Detail</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="220">Fee Name</th>
                <td>{{ $feeStructure->name }}</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>Rs. {{ number_format($feeStructure->amount, 2) }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($feeStructure->status) }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $feeStructure->description ?? '-' }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.fee-structures.edit', $feeStructure) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('admin.fee-structures.index') }}" class="btn btn-light">Back</a>
    </div>
</div>
@endsection
