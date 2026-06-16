@extends('layouts.app', ['title' => 'Request Center'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Request Center</h5>
            <small class="text-muted">Centralized overview of all your hostel requests</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Total Requests" :value="$totalRequests" subtitle="All submitted requests" icon="ph ph-files" color="primary" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Pending" :value="$pendingRequests" subtitle="Awaiting action" icon="ph ph-hourglass" color="warning" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Approved / Resolved" :value="$approvedRequests" subtitle="Successfully completed" icon="ph ph-check-circle" color="success" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Rejected" :value="$rejectedRequests" subtitle="Declined requests" icon="ph ph-x-circle" color="danger" />
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 class="mb-0">Request Modules</h5>
            <small class="text-muted">Open, create and track your requests</small>
        </div>

        <div class="card-body">
            <div class="row">
                @foreach($requestModules as $module)
                    <div class="col-md-6 col-xl-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-{{ $module['color'] }} bg-opacity-10 text-{{ $module['color'] }} d-flex align-items-center justify-content-center me-3"
                                     style="width: 52px; height: 52px;">
                                    <i class="{{ $module['icon'] }}" style="font-size: 26px;"></i>
                                </div>

                                <div>
                                    <h5 class="mb-0">{{ $module['title'] }}</h5>
                                    <small class="text-muted">{{ $module['description'] }}</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between border-top pt-3 mb-3">
                                <div>
                                    <small class="text-muted">Total</small>
                                    <h5 class="mb-0">{{ $module['total'] }}</h5>
                                </div>

                                <div class="text-end">
                                    <small class="text-muted">Pending</small>
                                    <h5 class="mb-0">{{ $module['pending'] }}</h5>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ $module['route'] }}" class="btn btn-sm btn-outline-primary w-50">
                                    View
                                </a>

                                <a href="{{ $module['create'] }}" class="btn btn-sm btn-primary w-50">
                                    New
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
