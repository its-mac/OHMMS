<div class="border rounded p-3 h-100">
    @isset($icon)
        <i class="{{ $icon }} d-block mb-2 text-{{ $color ?? 'primary' }}" style="font-size: 28px;"></i>
    @endisset

    <small class="text-muted">{{ $label }}</small>

    <h6 class="mb-0 mt-1">
        {{ $value ?? '-' }}
    </h6>
</div>
