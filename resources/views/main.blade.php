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

    @include('essential.footer-template')
</body>

</html>
