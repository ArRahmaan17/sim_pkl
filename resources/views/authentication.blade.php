<!DOCTYPE html>
<html lang="en">

<head>
    @include('essential.head-template')
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5 align-item-center">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                        <x-brand-icon />
                        @yield('content')
                        <div class="simple-footer" role="contentinfo">
                            <x-footer-single-page />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('essential.footer-template')
</body>

</html>
