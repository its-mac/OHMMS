@extends('layouts.app', ['title' => 'Guest Meal Detail'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Guest Meal Detail</h5>
            <small class="text-muted">View your guest meal request status and details</small>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Guest Meal Request</h5>
                        <small class="text-muted">
                            Submitted on {{ $guestMeal->created_at->format('d M Y h:i A') }}
                        </small>
                    </div>

                    <x-status-badge :status="$guestMeal->status" />
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Meal Date</small>
                                <h6 class="mb-0 mt-1">
                                    {{ \Carbon\Carbon::parse($guestMeal->meal_date)->format('d M Y') }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Meal Session</small>
                                <h6 class="mb-0 mt-1">{{ $guestMeal->mealSession->name ?? '-' }}</h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Guest Count</small>
                                <h6 class="mb-0 mt-1">{{ $guestMeal->guest_count }} guest(s)</h6>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <small class="text-muted">Current Status</small>
                                <br>
                                <x-status-badge :status="$guestMeal->status" />
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="border rounded p-3">
                                <small class="text-muted">Remarks</small>
                                <p class="mb-0 mt-1">{{ $guestMeal->remarks ?? 'No remarks provided.' }}</p>
                            </div>
                        </div>

                        @if(isset($guestMeal->manager_response) || isset($guestMeal->manager_remarks))
                            <div class="col-md-12 mb-3">
                                <div class="border rounded p-3 bg-info bg-opacity-10">
                                    <small class="text-muted">Manager Response</small>
                                    <p class="mb-0 mt-1">
                                        {{ $guestMeal->manager_response ?? $guestMeal->manager_remarks ?? 'No response yet.' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('student.guest-meals.index') }}" class="btn btn-light">
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
                        <small class="text-muted">{{ $guestMeal->created_at->format('d M Y h:i A') }}</small>
                    </div>

                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="mb-1">Current Status</h6>
                        <x-status-badge :status="$guestMeal->status" />
                    </div>

                    <div>
                        <h6 class="mb-1">Last Updated</h6>
                        <small class="text-muted">{{ $guestMeal->updated_at->format('d M Y h:i A') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
