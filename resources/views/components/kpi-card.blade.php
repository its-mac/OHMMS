@props([
    'title',
    'value',
    'subtitle' => '',
    'icon' => 'ph ph-chart-bar',
    'color' => 'primary',
])

<div class="card bg-{{ $color }}">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h6 class="mb-2 text-white">{{ $title }}</h6>
                <h3 class="text-white mb-0 f-w-300">{{ $value }}</h3>
                <p class="text-white-50 mb-0">{{ $subtitle }}</p>
            </div>

            <i class="{{ $icon }} text-white" style="font-size: 38px;"></i>
        </div>
    </div>
</div>
