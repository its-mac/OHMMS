<title>{{ $title ?? config('app.name', 'Online Hostel & Mess Management System') }}</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="description" content="Online Hostel and Mess Management System.">
<meta name="keywords" content="hostel, mess, attendance, biometric, management">
<meta name="author" content="Hostel Management Team">

<link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/svg+xml">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300..700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/css/plugins/phosphor-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/tabler-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
<link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
