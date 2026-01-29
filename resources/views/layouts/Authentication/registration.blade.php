@extends('authentication')
@section('title')
    {{ __('menus.registration') }}
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">
            @if (app('request')->has('action'))
                <div class="alert alert-danger alert-has-icon">
                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                    <div class="alert-body">
                        <div class="alert-title">Error</div>
                        {{ base64_decode(app('request')->action) }}
                    </div>
                </div>
            @endif
            <form method="POST" action="{{ route('authentication.registing') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control @error('username') is-invalid  @enderror" name="username">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="password" class="d-block">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror pwstrength"
                            data-indicator="pwindicator" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="pwindicator" class="pwindicator">
                            <div class="bar"></div>
                            <div class="label"></div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="confirm_password" class="d-block">Password Confirmation</label>
                        <input id="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                            name="password_confirm">
                        @error('confirm_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="agree" class="custom-control-input @error('agree') is-invalid @enderror" id="agree">
                        <label class="custom-control-label" for="agree">I agree with the terms
                            and conditions</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Register &nbsp;<i class="fas fa-arrow-right fa-xs"></i>
                    </button>
                    <a href="{{ route('authentication.index') }}" class="btn btn-success btn-lg btn-block">
                        Go Back &nbsp;<i class="fas fa-arrow-right fa-xs"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('vendor-js')
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            const now = new Date().getFullYear();
            document.querySelector('#year-now').setHTMLUnsafe(`${now}`);
        })
    </script>
@endpush
