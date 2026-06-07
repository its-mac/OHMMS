@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="mb-0">Dashboard</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6 col-xl-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <h6 class="mb-2 text-white">Hostels</h6>
                    <h3 class="text-white mb-0 f-w-300">0</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-success">
                <div class="card-body">
                    <h6 class="mb-2 text-white">Managers</h6>
                    <h3 class="text-white mb-0 f-w-300">0</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <h6 class="mb-2 text-white">Students</h6>
                    <h3 class="text-white mb-0 f-w-300">0</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card bg-info">
                <div class="card-body">
                    <h6 class="mb-2 text-white">Attendance Today</h6>
                    <h3 class="text-white mb-0 f-w-300">0</h3>
                </div>
            </div>
        </div>

    </div>
@endsection
