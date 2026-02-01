@extends('layouts.app')

@section('title', 'লোন এডিট')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">লোন এডিট</h2>
        <div>
            <a href="{{ route('loans.show', $loan) }}" class="btn btn-primary btn-sm me-2">
                <i class="fas fa-eye me-1"></i> বিস্তারিত
            </a>
            <a href="{{ route('loans.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> ফিরে যান
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('loans.update', $loan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">লোনের ধরণ</label>
                    <div class="form-control bg-light">
                        {{ $loan->type == 'Given' ? 'দেওয়া হয়েছে' : 'নেওয়া হয়েছে' }}
                    </div>
                    <input type="hidden" name="type" value="{{ $loan->type }}">
                </div>
                
                <div class="mb-3">
                    <label for="amount" class="form-label">পরিমাণ</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount', $loan->amount) }}" 
                           step="0.01" min="0.01" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="person_name" class="form-label">ব্যক্তির নাম</label>
                    <input type="text" name="person_name" id="person_name" 
                           value="{{ old('person_name', $loan->person_name) }}" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="contact_info" class="form-label">যোগাযোগের তথ্য (ঐচ্ছিক)</label>
                    <input type="text" name="contact_info" id="contact_info" 
                           value="{{ old('contact_info', $loan->contact_info) }}" class="form-control">
                </div>
                
                <div class="mb-3">
                    <label for="date" class="form-label">তারিখ</label>
                    <input type="date" name="date" id="date" 
                           value="{{ old('date', $loan->date ? $loan->date->format('Y-m-d') : '') }}" 
                           class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="due_date" class="form-label">শোধের তারিখ (ঐচ্ছিক)</label>
                    <input type="date" name="due_date" id="due_date" 
                           value="{{ old('due_date', $loan->due_date ? $loan->due_date->format('Y-m-d') : '') }}" 
                           class="form-control">
                </div>
                
                <div class="mb-3">
                    <label for="is_settled" class="form-label">স্ট্যাটাস</label>
                    <select name="is_settled" id="is_settled" class="form-select" required>
                        <option value="0" {{ (old('is_settled', $loan->is_settled) == 0) ? 'selected' : '' }}>বাকি আছে</option>
                        <option value="1" {{ (old('is_settled', $loan->is_settled) == 1) ? 'selected' : '' }}>শোধ হয়েছে</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="notes" class="form-label">নোট (ঐচ্ছিক)</label>
                    <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes', $loan->notes) }}</textarea>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> আপডেট করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    @if($loan->payments && count($loan->payments) > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">পেমেন্ট ইতিহাস</h5>
            </div>
            <div class="list-group list-group-flush">
                @foreach($loan->payments as $payment)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-medium">{{ $payment->date->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $payment->notes }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-medium">৳ {{ number_format($payment->amount, 2) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection 