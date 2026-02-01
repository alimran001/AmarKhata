@extends('layouts.app')

@section('title', 'হিসাব সম্পাদনা')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">হিসাব সম্পাদনা করুন - {{ $account->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('accounts.update', $account) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">হিসাবের নাম <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $account->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="type" class="form-label">হিসাবের ধরন <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">হিসাবের ধরন নির্বাচন করুন</option>
                                <option value="Cash" {{ old('type', $account->type) == 'Cash' ? 'selected' : '' }}>ক্যাশ</option>
                                <option value="Bank" {{ old('type', $account->type) == 'Bank' ? 'selected' : '' }}>ব্যাংক</option>
                                <option value="Mobile Banking" {{ old('type', $account->type) == 'Mobile Banking' ? 'selected' : '' }}>মোবাইল ব্যাংকিং</option>
                                <option value="Other" {{ old('type', $account->type) == 'Other' ? 'selected' : '' }}>অন্যান্য</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> বর্তমান ব্যালেন্স: <strong>{{ number_format($account->current_balance, 2) }} টাকা</strong>
                            <p class="small mb-0 mt-1">আপনি শুধুমাত্র ট্রানজেকশন তৈরির মাধ্যমে ব্যালেন্স পরিবর্তন করতে পারবেন।</p>
                        </div>
                        
                        <div class="mb-3 bank-field" style="display: none;">
                            <label for="account_number" class="form-label">হিসাব নম্বর</label>
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number', $account->account_number) }}">
                            @error('account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('accounts.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> ফিরে যান
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> পরিবর্তন সংরক্ষণ করুন
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
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const bankFields = document.querySelectorAll('.bank-field');
        
        typeSelect.addEventListener('change', function() {
            const showBankFields = ['Bank', 'Mobile Banking'].includes(this.value);
            
            bankFields.forEach(field => {
                field.style.display = showBankFields ? 'block' : 'none';
            });
        });
        
        // Initialize on page load
        typeSelect.dispatchEvent(new Event('change'));
    });
</script>
@endpush
@endsection 