@extends('layouts.app')

@section('title', 'প্রোফাইল')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">প্রোফাইল</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">নাম</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">ইমেইল</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">ফোন</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ auth()->user()->phone }}">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">ঠিকানা</label>
                            <textarea class="form-control" id="address" name="address" rows="2">{{ auth()->user()->address }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">আপডেট</button>
                    </form>
                </div>
            </div>
            
            <!-- পাসওয়ার্ড পরিবর্তন -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">পাসওয়ার্ড পরিবর্তন</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">বর্তমান পাসওয়ার্ড</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">নতুন পাসওয়ার্ড</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">পাসওয়ার্ড পরিবর্তন</button>
                    </form>
                </div>
            </div>

            <!-- অ্যাকাউন্ট সেটিংস -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">অ্যাকাউন্ট সেটিংস</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deactivateAccountModal">
                            <i class="fas fa-user-slash me-2"></i>অ্যাকাউন্ট ডিঅ্যাক্টিভেট
                        </button>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="fas fa-user-times me-2"></i>অ্যাকাউন্ট ডিলিট
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Account Modal -->
<div class="modal fade" id="deactivateAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">অ্যাকাউন্ট ডিঅ্যাক্টিভেট</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>আপনি কি নিশ্চিত যে আপনি আপনার অ্যাকাউন্ট ডিঅ্যাক্টিভেট করতে চান?</p>
                <p class="text-danger">সতর্কতা: ডিঅ্যাক্টিভেট করার পর আপনি লগইন করতে পারবেন না।</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                <form action="{{ route('account.deactivate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">ডিঅ্যাক্টিভেট</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">অ্যাকাউন্ট ডিলিট</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>আপনি কি নিশ্চিত যে আপনি আপনার অ্যাকাউন্ট ডিলিট করতে চান?</p>
                <p class="text-danger">সতর্কতা: ডিলিট করার পর আপনার সব ডাটা মুছে যাবে এবং পুনরুদ্ধার করা যাবে না।</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                <form action="{{ route('account.delete') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">ডিলিট</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 