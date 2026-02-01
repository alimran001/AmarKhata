@extends('layouts.app')

@section('title', 'পাসওয়ার্ড পরিবর্তন')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-lock text-primary me-2"></i>পাসওয়ার্ড পরিবর্তন
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('password.update.post') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">বর্তমান পাসওয়ার্ড</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">নতুন পাসওয়ার্ড</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input type="password" class="form-control" 
                                id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>ফিরে যান
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>পাসওয়ার্ড আপডেট করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus {
    border-color: #FE5B56;
    box-shadow: 0 0 0 0.25rem rgba(254, 91, 86, 0.25);
}

.btn-primary {
    background-color: #FE5B56;
    border-color: #FE5B56;
}

.btn-primary:hover {
    background-color: #e04b46;
    border-color: #e04b46;
}
</style>
@endsection 