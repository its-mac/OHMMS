@extends('layouts.app')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <h4 class="mb-0">Mess Menu Detail</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Date</th>
                    <td>{{ \Carbon\Carbon::parse($messMenu->menu_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Meal Session</th>
                    <td>{{ $messMenu->mealSession->name }}</td>
                </tr>
                <tr>
                    <th>Menu Items</th>
                    <td>{!! nl2br(e($messMenu->menu_items)) !!}</td>
                </tr>
            </table>

            <a href="{{ route('admin.mess-menus.edit', $messMenu) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.mess-menus.index') }}" class="btn btn-light">Back</a>
        </div>
    </div>
</div>
@endsection
