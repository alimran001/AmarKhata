@extends('layouts.app')

@section('title', 'ব্যবহারকারী তথ্য')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>ব্যবহারকারী তথ্য</h2>
            <p class="text-muted">ব্যবহারকারীর বিস্তারিত তথ্য দেখুন</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> সকল ব্যবহারকারী
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> সম্পাদনা করুন
            </a>
            <a href="{{ route('admin.users.change-password', $user) }}" class="btn btn-warning">
                <i class="fas fa-key"></i> পাসওয়ার্ড পরিবর্তন
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">প্রোফাইল</h5>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-lg mb-3 mx-auto bg-primary text-white rounded-circle">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">
                        <i class="fas fa-envelope me-1"></i> {{ $user->email }}
                    </p>
                    @if($user->phone)
                        <p class="text-muted">
                            <i class="fas fa-phone me-1"></i> {{ $user->phone }}
                        </p>
                    @endif
                    <p class="mb-0">
                        <span class="badge bg-info">ID: {{ $user->id }}</span>
                        @if($user->id === 1)
                            <span class="badge bg-danger">অ্যাডমিন</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">অ্যাকাউন্ট তথ্য</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 200px;">ব্যবহারকারী আইডি</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>নাম</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>ইমেইল</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>ফোন</th>
                                <td>{{ $user->phone ?? 'দেওয়া হয়নি' }}</td>
                            </tr>
                            <tr>
                                <th>ভাষা</th>
                                <td>{{ $user->language ?? 'বাংলা' }}</td>
                            </tr>
                            <tr>
                                <th>ইমেইল ভেরিফাইড</th>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i> ভেরিফাইড ({{ $user->email_verified_at->format('d M Y, h:i A') }})
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-exclamation-circle me-1"></i> ভেরিফাই করা হয়নি
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>অ্যাকাউন্ট তৈরি</th>
                                <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>সর্বশেষ আপডেট</th>
                                <td>{{ $user->updated_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">হিসাব সংক্ষিপ্ত বিবরণ</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card border-0 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-wallet fa-2x text-primary mb-2"></i>
                                    <h6>মোট হিসাব</h6>
                                    <h4>{{ $user->accounts->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-exchange-alt fa-2x text-success mb-2"></i>
                                    <h6>মোট লেনদেন</h6>
                                    <h4>{{ $user->transactions->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-tags fa-2x text-warning mb-2"></i>
                                    <h6>মোট বিভাগ</h6>
                                    <h4>{{ $user->categories->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-lg {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: bold;
    }
</style>
@endsection 