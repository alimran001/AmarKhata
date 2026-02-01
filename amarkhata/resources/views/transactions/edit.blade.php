@extends('layouts.app')

@section('title', 'লেনদেন সম্পাদনা')

@section('content')
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">
            <i class="fas fa-edit text-primary me-2"></i>লেনদেন সম্পাদনা
        </h5>
        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>ফিরে যান
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="alert alert-info small mb-3">
                <i class="fas fa-info-circle me-1"></i> আপনি লেনদেনের তথ্য সম্পাদনা করতে পারেন। ভুল হলে সংশোধন করুন।
            </div>
            
            <form action="{{ route('transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- মূল তথ্য -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="type" class="form-label">লেনদেনের ধরন</label>
                        <select name="type" id="type" class="form-select" disabled>
                            <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>আয়</option>
                            <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>ব্যয়</option>
                            <option value="transfer" {{ $transaction->type == 'transfer' ? 'selected' : '' }}>ট্রান্সফার</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="account_id" class="form-label">হিসাব</label>
                        <select name="account_id" id="account_id" class="form-select" disabled>
                            <option selected>{{ $transaction->account->name }}</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="amount" class="form-label">পরিমাণ</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ $transaction->amount }}" step="0.01" min="0.01" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="date" class="form-label">তারিখ</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $transaction->date->format('Y-m-d') }}" disabled>
                    </div>
                    
                    @if($transaction->type == 'transfer')
                        <div class="col-md-6">
                            <label class="form-label">প্রাপক হিসাব</label>
                            <input type="text" class="form-control" value="{{ $transaction->transferToAccount->name }}" disabled>
                        </div>
                    @endif
                </div>
                
                <!-- সম্পাদনাযোগ্য ক্ষেত্র -->
                @if($transaction->type != 'transfer')
                    <div class="mb-3">
                        <label for="category_id" class="form-label">বিভাগ</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">বিভাগ নেই</option>
                            @foreach($categories as $category)
                                @if($category->type == $transaction->type)
                                    <option value="{{ $category->id }}" {{ $transaction->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif
                
                <div class="mb-3">
                    <label for="note" class="form-label">বিবরণ</label>
                    <textarea name="note" id="note" rows="2" class="form-control">{{ $transaction->note }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label for="attachment" class="form-label">সংযুক্তি</label>
                    
                    @if($transaction->attachment)
                        <div class="mb-2">
                            <a href="{{ Storage::url($transaction->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-file me-1"></i>বর্তমান সংযুক্তি দেখুন
                            </a>
                        </div>
                    @endif
                    
                    <input type="file" name="attachment" id="attachment" class="form-control">
                    <div class="form-text">সর্বোচ্চ ফাইল সাইজ: 2MB। অনুমোদিত ফরম্যাট: jpg, png, pdf</div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>আপডেট করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 