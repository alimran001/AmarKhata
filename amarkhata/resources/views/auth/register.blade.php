@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
            <!-- লোগো এবং লিংক রিমুভ করা হয়েছে -->
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">{{ __('app.register') }}</h4>
                </div>

                <div class="card-body p-3 p-sm-4">
                    <form method="POST" action="{{ route('register') }}" class="auth-form">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('Phone Number') }} ({{ __('Optional') }})</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">
                                {{ __('app.register') }}
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-center py-3">
                    <p class="mb-0">
                        {{ __('Already have an account?') }} 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold">{{ __('app.login') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 