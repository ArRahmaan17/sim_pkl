<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="description" content="A concise, compelling description of your page content (approx. 150-160 characters) to improve click-through rates.">
    <link rel="canonical" href="{{ env('APP_URL') }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Descriptive Page Title">
    <meta property="og:description" content="A concise description for social media sharing.">
    <meta property="og:image" content="https://www.example.com/image.webp">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Descriptive Page Title">
    <meta name="twitter:description" content="A concise description for Twitter.">
    <title>{{ env('APP_NAME') }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}"> --}}

    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}"> --}}

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
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
        <section class="section">
            <div class="container mt-5 align-item-center">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                        <x-brand-icon />
                        <div class="card card-primary" role="main">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('authentication.login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="credential">Email/Username</label>
                                        <input id="credential" type="text" class="form-control @error('credential') is-invalid @enderror"
                                            name="credential" tabindex="1" autofocus>
                                        @error('credential')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="auth-forgot-password.html" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                            tabindex="2">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                        <div class="text-center mt-1">
                                            Don't have an account? <a href="{{ route('register.index') }}">Create One</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <x-footer-single-page />
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            const now = new Date().getFullYear();
            document.querySelector('#year-now').setHTMLUnsafe(`${now}`);
        })
    </script>
</body>

</html>
