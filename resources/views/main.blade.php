<!DOCTYPE html>
<html lang="en">

<head>
    @include('essential.head-template')
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
                        {{-- fix this --}}
                        <h1>{{ Str::headline(implode(' > ', explode('.', app('request')->route()->getName()))) }} Page
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
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <script>
        function alertLoading() {
            swal('Loading', {
                button: false,
                closeOnClickOutside: false,
                icon: `{{ asset('assets/img/loading.gif') }}`
            });
        }
    </script>
    @yield('script')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
