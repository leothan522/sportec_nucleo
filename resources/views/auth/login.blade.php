@extends('layouts.auth-bootstrap')

@section('title', __('Log in'))

@section('content')

    <form class="needs-validation position-relative" method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        @if ($errors->any())
            <div>
                <div class="fs-6 text-danger fw-normal">{{ __('Whoops! Something went wrong.') }}</div>

                <ul class="mt-3 fs-6 text-danger fw-normal">
                    @foreach ($errors->all() as $error)
                        <li><small>{{ $error }}</small></li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4">
                <p class="fs-6 d-flex text-success fw-normal" style="text-align: justify !important;">
                    <small>{{ session('status') }}</small>
                </p>
            </div>
        @endif

        <div class="form-floating mb-3 has-validation">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus />
            <label for="email">{{ __('Email') }}</label>
            <div class="invalid-feedback">
                Por favor ingrese su {{ __('Email') }}.
            </div>
        </div>

        <div class="form-floating mb-3 has-validation">
            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
            <label for="password">{{ __('Password') }}</label>
            <div class="invalid-feedback">
                Por favor ingrese su {{ __('Password') }}.
            </div>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" name="remember" id="remember_me">
                <label class="form-check-label text-secondary" for="remember_me">
                    {{ __('Remember me') }}
                </label>
            </div>
        </div>

        <div class="text-center pt-1 mb-3 pb-1 d-grid gap-2">

            <button type="submit" class="btn shadow text-white btn-block fa-lg gradient-custom-2 mb-3">{{ __('Log in') }}</button>

            @if (Route::has('password.request'))
                <a class="text-muted" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
            @endif
        </div>

        <div class="d-flex align-items-center justify-content-center">
            @if (Route::has('register'))
                <p class="mb-0 me-2">¿No tienes una cuenta?</p>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">{{ __('Register') }}</a>
            @endif
        </div>

        <div class="position-absolute top-50 start-50 translate-middle d-none verCargando">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

    </form>

@endsection

