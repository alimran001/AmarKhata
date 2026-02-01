@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
            <!-- লোগো এবং লিংক রিমুভ করা হয়েছে -->
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">{{ __('app.login') }}</h4>
                </div>

                <div class="card-body p-3 p-sm-4">
                    <form method="POST" action="{{ route('login') }}" class="auth-form">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary py-2">
                                {{ __('app.login') }}
                            </button>
                        </div>

                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-center py-3">
                    <p class="mb-0">
                        {{ __("Don't have an account?") }} 
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold">{{ __('app.register') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 