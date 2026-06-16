<a href="{{ $href }}" class="btn btn-outline-{{ $color ?? 'primary' }} w-100 {{ $class ?? '' }}">
    @isset($icon)
        <i class="{{ $icon }} d-block mb-2" style="font-size: 28px;"></i>
    @endisset

    {{ $slot }}
</a>
