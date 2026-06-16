@props([
    'icon' => 'ph ph-info',
    'title' => 'No records found',
    'message' => null,
])

<div class="text-center py-5">
    <i class="{{ $icon }} text-muted d-block mb-2" style="font-size: 42px;"></i>

    <h6 class="mb-1">{{ $title }}</h6>

    @if($message)
        <p class="text-muted mb-0">{{ $message }}</p>
    @endif
</div>
