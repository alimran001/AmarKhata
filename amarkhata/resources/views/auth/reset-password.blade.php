@extends('layouts.app')

@section('title', 'পাসওয়ার্ড রিসেট')

@section('content')
<div class="container h-100">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="col-md-5">
            <!-- লোগো এবং লিংক রিমুভ করা হয়েছে -->
            
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0">পাসওয়ার্ড রিসেট</h5>
                </div>
                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">ইমেইল ঠিকানা</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">নতুন পাসওয়ার্ড</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2">
                                পাসওয়ার্ড রিসেট করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 