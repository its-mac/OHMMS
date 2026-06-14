@extends('layouts.app', ['title' => 'Fee Structures'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Fee Structures</h5>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Fee Structure List</h5>
        <a href="{{ route('admin.fee-structures.create') }}" class="btn btn-primary btn-sm">
            Add Fee Structure
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fee Name</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th width="220">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feeStructures as $fee)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $fee->name }}</td>
                        <td>Rs. {{ number_format($fee->amount, 2) }}</td>
                        <td>{{ ucfirst($fee->status) }}</td>
                        <td>
                            <a href="{{ route('admin.fee-structures.show', $fee) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('admin.fee-structures.edit', $fee) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('admin.fee-structures.destroy', $fee) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this fee structure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No fee structures found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $feeStructures->links() }}
    </div>
</div>
@endsection
