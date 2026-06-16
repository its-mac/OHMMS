@props(['status'])

@php
    $class = match($status) {
        'approved', 'resolved', 'paid', 'active' => 'success',
        'rejected', 'unpaid', 'inactive' => 'danger',
        'partial', 'pending', 'in_progress' => 'warning',
        default => 'secondary',
    };
@endphp

<span class="badge bg-{{ $class }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
