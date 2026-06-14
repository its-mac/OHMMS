@extends('layouts.app', ['title' => 'Weekly Mess Menu'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Weekly Mess Menu</h5>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>
            Menu From {{ $startDate->format('d M Y') }}
            to {{ $endDate->format('d M Y') }}
        </h5>
    </div>

    <div class="card-body">
        @for($date = $startDate->copy(); $date->lte($endDate); $date->addDay())
            @php
                $dateKey = $date->format('Y-m-d');
                $dayMenus = $menus[$dateKey] ?? collect();
            @endphp

            <div class="mb-4">
                <h6 class="border-bottom pb-2">
                    {{ $date->format('l, d M Y') }}
                </h6>

                @if($dayMenus->count())
                    <div class="row">
                        @foreach($dayMenus as $menu)
                            <div class="col-md-4 mb-3">
                                <div class="card border">
                                    <div class="card-header">
                                        <strong>{{ $menu->mealSession->name }}</strong>
                                    </div>
                                    <div class="card-body">
                                        {!! nl2br(e($menu->menu_items)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No menu added for this day.</p>
                @endif
            </div>
        @endfor
    </div>
</div>
@endsection
