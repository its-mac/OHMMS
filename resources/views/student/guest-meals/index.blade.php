@extends('layouts.app', ['title' => 'Guest Meals'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Guest Meal Requests</h5>
            <small class="text-muted">Track your guest meal requests and approval status</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $totalCount = $guestMeals->total();
        $pendingCount = $guestMeals->where('status', 'pending')->count();
        $approvedCount = $guestMeals->where('status', 'approved')->count();
        $rejectedCount = $guestMeals->where('status', 'rejected')->count();
    @endphp

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Total Requests" :value="$totalCount" subtitle="All guest meal requests" icon="ph ph-users-three" color="primary" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Pending" :value="$pendingCount" subtitle="Awaiting approval" icon="ph ph-hourglass" color="warning" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Approved" :value="$approvedCount" subtitle="Accepted requests" icon="ph ph-check-circle" color="success" />
        </div>

        <div class="col-md-6 col-xl-3">
            <x-kpi-card title="Rejected" :value="$rejectedCount" subtitle="Declined requests" icon="ph ph-x-circle" color="danger" />
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">My Guest Meal Requests</h5>
                <small class="text-muted">Latest guest meal request activity</small>
            </div>

            <a href="{{ route('student.guest-meals.create') }}" class="btn btn-primary btn-sm">
                <i class="ph ph-plus me-1"></i>
                New Request
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Meal Date</th>
                            <th>Meal Session</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th>Requested At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($guestMeals as $guestMeal)
                            <tr>
                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($guestMeal->meal_date)->format('d M Y') }}</strong>
                                </td>

                                <td>{{ $guestMeal->mealSession->name ?? '-' }}</td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $guestMeal->guest_count }} guest(s)
                                    </span>
                                </td>

                                <td>
                                    <x-status-badge :status="$guestMeal->status" />
                                </td>

                                <td>
                                    {{ $guestMeal->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $guestMeal->created_at->format('h:i A') }}</small>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('student.guest-meals.show', $guestMeal) }}" class="btn btn-sm btn-primary">
                                        <i class="ph ph-eye me-1"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-empty-state
                                        icon="ph ph-users-three"
                                        title="No guest meal requests found"
                                        message="You have not submitted any guest meal request yet."
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $guestMeals->links() }}
            </div>
        </div>
    </div>
@endsection
