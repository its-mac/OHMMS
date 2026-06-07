<!doctype html>
<html lang="en">

<head>
    @include('layouts.partials.head', ['title' => $title ?? 'Dashboard'])
    @stack('page-css')
</head>

<body data-pc-preset="preset-1"
      data-pc-sidebar-caption="true"
      data-pc-direction="ltr"
      data-pc-theme="light"
      data-pc-sidebar_theme="false">

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    @include('layouts.partials.sidebar')
    @include('layouts.partials.header')

    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    @include('layouts.partials.scripts')
    @stack('page-scripts')
</body>

</html>
