@extends('layouts.app')

@section('title', 'লোন যোগ করুন')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">লোন যোগ করুন</h2>
        <a href="{{ route('loans.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> লোন তালিকা
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="type" class="form-label">লোনের ধরণ <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="">ধরণ নির্বাচন করুন</option>
                        <option value="Given" {{ old('type') == 'Given' ? 'selected' : '' }}>আমি টাকা দিয়েছি</option>
                        <option value="Taken" {{ old('type') == 'Taken' ? 'selected' : '' }}>আমি টাকা নিয়েছি</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="account_id" class="form-label">অ্যাকাউন্ট <span class="text-danger">*</span></label>
                    <select name="account_id" id="account_id" class="form-select" required>
                        <option value="">অ্যাকাউন্ট নির্বাচন করুন</option>
                        @foreach(App\Models\Account::where('user_id', Auth::id())->get() as $account)
                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                {{ $account->name }} ({{ $account->type }}) - ৳{{ number_format($account->current_balance, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="row g-2">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="person_name" class="form-label">ব্যক্তির নাম <span class="text-danger">*</span></label>
                            <input type="text" name="person_name" id="person_name" value="{{ old('person_name') }}" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="amount" class="form-label">পরিমাণ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" step="0.01" min="0.01" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="due_date" class="form-label">সম্ভাব্য শোধের তারিখ</label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="form-control">
                </div>
                
                <div class="mb-3">
                    <label for="note" class="form-label">নোট</label>
                    <textarea name="note" id="note" rows="2" class="form-control">{{ old('note') }}</textarea>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="is_settled" id="is_settled" {{ old('is_settled') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_settled">সম্পূর্ণ পরিশোধিত</label>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> সংরক্ষণ করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 