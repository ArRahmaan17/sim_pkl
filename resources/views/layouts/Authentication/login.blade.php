@extends('authentication')
@section('title')
    {{ __('menus.login') }}
@endsection
@section('content')
    <div class="card card-primary" role="main">
        <div class="card-header">
            <h4>Login</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('authentication.login') }}">
                @csrf
                <div class="form-group">
                    <label for="credential">Email/Username</label>
                    <input id="credential" type="text" class="form-control @error('credential') is-invalid @enderror" name="credential" tabindex="1"
                        autofocus>
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
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2">
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
                        Don't have an account? <a href="{{ route('authentication.registration') }}">Create One</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
