<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ env('APP_NAME') }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/bootstrap-daterangepicker/daterangepicker.css') }}">

    <!-- CSS Libraries -->
    @yield('css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    <!-- Start GA -->
    
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('components.navbar')
            @include('components.sidebar')
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>{{ Str::headline(implode(' > ',explode('.',app('request')->route()->getName()))) }} Page
                        </h1>
                    </div>

                    <div class="section-body">
                        @if (session('success'))
                            <div class="col-12">
                                <div class="alert alert-success">{!! session('success') !!}</div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="col-12">
                                <div class="alert alert-danger">{!! session('error') !!}</div>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </section>
            </div>
            @include('components.footer')
        </div>
    </div>
    @yield('modals')

    <!-- General JS Scripts -->
    <script src="{{ asset('modules/jquery.min.js') }}"></script>
    <script src="{{ asset('modules/popper.js') }}"></script>
    <script src="{{ asset('modules/tooltip.js') }}"></script>
    <script src="{{ asset('modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('modules/moment.min.js') }}"></script>
    <script src="{{ asset('modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <script>
        function alertLoading() {
            swal('Loading', {
                button: false,
                closeOnClickOutside: false,
                icon: `{{ asset('img/loading.gif') }}`
            });
        }
    </script>
    @yield('script')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
