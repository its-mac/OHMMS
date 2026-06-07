<!doctype html>
<html lang="en">

<head>
    @include('layouts.partials.head', ['title' => $title ?? 'Authentication'])
    @stack('page-css')
</head>

<body data-pc-preset="preset-1"
      data-pc-sidebar-caption="true"
      data-pc-direction="ltr"
      data-pc-theme="light"
      data-pc-sidebar_theme="false">

    @yield('content')

    @include('layouts.partials.scripts')
    @stack('page-scripts')
</body>

</html>
