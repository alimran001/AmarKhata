@extends('layouts.app')

@section('title', 'লোন বিস্তারিত')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">লোন বিস্তারিত</h2>
        <div>
            <a href="{{ route('loans.edit', $loan) }}" class="btn btn-primary btn-sm me-2">
                <i class="fas fa-edit me-1"></i> এডিট
            </a>
            <a href="{{ route('loans.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> ফিরে যান
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">লোন তথ্য</h5>
                <span class="badge {{ $loan->type == 'Given' ? 'bg-primary' : 'bg-info' }}">
                    {{ $loan->type == 'Given' ? 'দেওয়া হয়েছে' : 'নেওয়া হয়েছে' }}
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label text-muted">ব্যক্তি</label>
                    <div class="fw-medium">{{ $loan->person_name }}</div>
                    @if($loan->contact_info)
                        <small class="text-muted">{{ $loan->contact_info }}</small>
                    @endif
                </div>
                
                <div class="col-6">
                    <label class="form-label text-muted">স্ট্যাটাস</label>
                    <div>
                        <span class="badge {{ $loan->is_settled ? 'bg-success' : 'bg-warning' }}">
                            {{ $loan->is_settled ? 'শোধ হয়েছে' : 'বাকি আছে' }}
                        </span>
                    </div>
                </div>
                
                <div class="col-6">
                    <label class="form-label text-muted">পরিমাণ</label>
                    <div class="fw-medium">৳ {{ number_format($loan->amount, 2) }}</div>
                </div>
                
                <div class="col-6">
                    <label class="form-label text-muted">তারিখ</label>
                    <div class="fw-medium">{{ $loan->date ? $loan->date->format('d/m/Y') : 'N/A' }}</div>
                </div>
                
                @if($loan->due_date)
                <div class="col-6">
                    <label class="form-label text-muted">শোধের তারিখ</label>
                    <div class="fw-medium {{ $loan->due_date < now() && !$loan->is_settled ? 'text-danger' : '' }}">
                        {{ $loan->due_date->format('d/m/Y') }}
                        @if($loan->due_date < now() && !$loan->is_settled)
                            <small class="text-danger">(মেয়াদ উত্তীর্ণ)</small>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            @if($loan->notes)
            <div class="mt-3 pt-3 border-top">
                <label class="form-label text-muted">নোট</label>
                <div>{{ $loan->notes }}</div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- পেমেন্ট রেকর্ড -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">পেমেন্ট ইতিহাস</h5>
        @if(!$loan->is_settled)
        <button type="button" class="btn btn-success btn-sm" 
                onclick="document.getElementById('add-payment-modal').classList.remove('d-none')">
            <i class="fas fa-plus me-1"></i> পেমেন্ট যোগ করুন
        </button>
        @endif
    </div>
    
    <div class="card">
        @if($loan->payments->count() > 0)
            <div class="list-group list-group-flush">
                @foreach($loan->payments as $payment)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-medium">{{ $payment->date->format('d/m/Y') }}</div>
                                @if($payment->notes)
                                    <small class="text-muted">{{ $payment->notes }}</small>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="fw-medium">৳ {{ number_format($payment->amount, 2) }}</div>
                                @if(!$loan->is_settled)
                                <form action="{{ route('loan-payments.destroy', $payment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link btn-sm text-danger p-0" 
                                            onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই পেমেন্ট রেকর্ড মুছতে চান?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card-body text-center text-muted">
                কোন পেমেন্ট রেকর্ড পাওয়া যায়নি
            </div>
        @endif
    </div>
    
    <!-- পেমেন্ট যোগ করার মডাল -->
    <div id="add-payment-modal" class="modal fade d-none" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">পেমেন্ট যোগ করুন</h5>
                    <button type="button" class="btn-close" 
                            onclick="document.getElementById('add-payment-modal').classList.add('d-none')"></button>
                </div>
                
                <form action="{{ route('loan-payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="amount" class="form-label">পরিমাণ</label>
                            <input type="number" name="amount" id="amount" step="0.01" min="0.01" 
                                   max="{{ $loan->amount - $loan->paid_amount }}" class="form-control" required>
                            <small class="text-muted">বাকি পরিমাণ: ৳ {{ number_format($loan->amount - $loan->paid_amount, 2) }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">তারিখ</label>
                            <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" 
                                   class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">নোট (ঐচ্ছিক)</label>
                            <textarea name="notes" id="notes" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                onclick="document.getElementById('add-payment-modal').classList.add('d-none')">
                            বাতিল
                        </button>
                        <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 