    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="ArRahmaan17, Doglex">
    <meta name="description" content="@hasSection('page-description') @yield('page-description') @else Manage your intern/staff as simple as you pay them @endif">
    <link rel="canonical" href="{{ env('APP_URL') }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="@hasSection('title') @yield('title') @else Dashboard @endif | {{ env('APP_NAME') }}">
    <meta property="og:description" content="@hasSection('page-description') @yield('page-description') @else Manage your intern/staff as simple as you pay them @endif">
    <meta property="og:image" content="{{ asset('assets/img/logo.webp') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@hasSection('title') @yield('title') @else Dashboard @endif | {{ env('APP_NAME') }}">
    <meta name="twitter:description" content="@hasSection('page-description') @yield('page-description') @else Manage your intern/staff as simple as you pay them @endif">
    <meta property="twitter:image" content="{{ asset('assets/img/logo.webp') }}">
    <title>
        @hasSection('title')
            @yield('title')
        @else
            Dashboard
        @endif | {{ env('APP_NAME') }}
    </title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    @push('vendor-css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skins/reverse.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
