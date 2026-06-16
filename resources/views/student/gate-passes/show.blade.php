@extends('layouts.app', ['title' => 'Gate Pass Detail'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Gate Pass Detail</h5>
            <small class="text-muted">View your gate pass request status and details</small>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Gate Pass Request</h5>
                        <small class="text-muted">
                            Submitted on {{ $gatePass->created_at->format('d M Y h:i A') }}
                        </small>
                    </div>

                    <x-status-badge :status="$gatePass->status" />
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Out Time</small>
                                <h6 class="mb-0 mt-1">{{ $gatePass->out_time->format('d M Y h:i A') }}</h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Expected Return Time</small>
                                <h6 class="mb-0 mt-1">{{ $gatePass->expected_return_time->format('d M Y h:i A') }}</h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Destination</small>
                                <h6 class="mb-0 mt-1">{{ $gatePass->destination }}</h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Contact During Outing</small>
                                <h6 class="mb-0 mt-1">{{ $gatePass->contact_during_outing ?? '-' }}</h6>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="border rounded p-3">
                                <small class="text-muted">Purpose</small>
                                <p class="mb-0 mt-1">{{ $gatePass->purpose }}</p>
                            </div>
                        </div>

                        @if(isset($gatePass->manager_response) || isset($gatePass->manager_remarks))
                            <div class="col-md-12 mb-3">
                                <div class="border rounded p-3 bg-info bg-opacity-10">
                                    <small class="text-muted">Manager Response</small>
                                    <p class="mb-0 mt-1">
                                        {{ $gatePass->manager_response ?? $gatePass->manager_remarks ?? 'No response yet.' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('student.gate-passes.index') }}" class="btn btn-light">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Request Timeline</h5>
                </div>

                <div class="card-body">
                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="mb-1">Submitted</h6>
                        <small class="text-muted">{{ $gatePass->created_at->format('d M Y h:i A') }}</small>
                    </div>

                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="mb-1">Current Status</h6>
                        <x-status-badge :status="$gatePass->status" />
                    </div>

                    <div>
                        <h6 class="mb-1">Last Updated</h6>
                        <small class="text-muted">{{ $gatePass->updated_at->format('d M Y h:i A') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
