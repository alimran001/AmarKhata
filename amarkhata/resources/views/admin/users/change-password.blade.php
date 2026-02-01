@extends('layouts.app')

@section('title', 'পাসওয়ার্ড পরিবর্তন')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>পাসওয়ার্ড পরিবর্তন</h2>
            <p class="text-muted">ব্যবহারকারীর পাসওয়ার্ড পরিবর্তন করুন</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> ফিরে যান
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">{{ $user->name }} - পাসওয়ার্ড পরিবর্তন</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> আপনি <strong>{{ $user->name }}</strong> ({{ $user->email }}) এর পাসওয়ার্ড পরিবর্তন করতে যাচ্ছেন।
                    </div>

                    <form action="{{ route('admin.users.update-password', $user) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">নতুন পাসওয়ার্ড <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text">কমপক্ষে ৮ অক্ষরের পাসওয়ার্ড দিন</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning" onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই ব্যবহারকারীর পাসওয়ার্ড পরিবর্তন করতে চান?')">
                                <i class="fas fa-key me-1"></i> পাসওয়ার্ড পরিবর্তন করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>
@endpush
@endsection 