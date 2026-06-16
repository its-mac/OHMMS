<div class="border rounded p-3 text-center h-100">

    @isset($icon)
        <i class="{{ $icon }} d-block mb-2 text-{{ $color ?? 'primary' }}"
           style="font-size: 28px;"></i>
    @endisset

    <h4 class="mb-1">
        {{ $value }}
    </h4>

    <small class="text-muted d-block">
        {{ $label }}
    </small>

    @isset($href)
        <div class="mt-2">
            <a href="{{ $href }}" class="btn btn-sm btn-light">
                {{ $button ?? 'View' }}
            </a>
        </div>
    @endisset

</div>
