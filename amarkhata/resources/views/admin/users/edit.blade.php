@extends('layouts.app')

@section('title', 'ব্যবহারকারী সম্পাদনা')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>ব্যবহারকারী সম্পাদনা</h2>
            <p class="text-muted">ব্যবহারকারীর তথ্য পরিবর্তন করুন</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> ফিরে যান
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $user->name }} - তথ্য সম্পাদনা</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">নাম <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">ইমেইল <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">ফোন</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> আপডেট করুন
                            </button>
                            <a href="{{ route('admin.users.change-password', $user) }}" class="btn btn-warning">
                                <i class="fas fa-key me-1"></i> পাসওয়ার্ড পরিবর্তন করুন
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 