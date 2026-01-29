    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="description" content="A concise, compelling description of your page content (approx. 150-160 characters) to improve click-through rates.">
    <link rel="canonical" href="{{ env('APP_URL') }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Descriptive Page Title">
    <meta property="og:description" content="A concise description for social media sharing.">
    <meta property="og:image" content="{{ asset('assets/img/logo.webp') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Descriptive Page Title">
    <meta name="twitter:description" content="A concise description for Twitter.">
    <title> @yield('title') | {{ env('APP_NAME') }}</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    @push('vendor-css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skins/reverse.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
