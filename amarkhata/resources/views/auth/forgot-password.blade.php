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

                    <p class="mb-4">আপনার পাসওয়ার্ড ভুলে গেছেন? কোন সমস্যা নেই। শুধু আপনার ইমেইল ঠিকানা দিন, আমরা আপনাকে একটি পাসওয়ার্ড রিসেট লিংক পাঠাবো।</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">ইমেইল ঠিকানা</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary py-2">
                                পাসওয়ার্ড রিসেট লিংক পাঠান
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                লগইন পেইজে ফিরে যান
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 