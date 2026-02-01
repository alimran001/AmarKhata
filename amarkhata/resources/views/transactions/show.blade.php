@extends('layouts.app')

@section('title', 'লেনদেন বিবরণ')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">লেনদেন বিবরণ</h2>
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> পিছনে
            </a>
            <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> সম্পাদনা
            </a>
        </div>
    </div>

    <!-- ডিলিট ফর্ম -->
    <div class="text-end mb-3">
        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই লেনদেনটি মুছতে চান?')">
                <i class="fas fa-trash me-1"></i> মুছুন
            </button>
        </form>
    </div>

    <!-- লেনদেন হেডার -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">তারিখ</div>
                            <div class="fw-bold">{{ $transaction->date->format('d/m/Y') }}</div>
                        </div>
                        <div>
                            @if($transaction->type == 'income')
                                <span class="badge bg-success fs-6">আয়</span>
                            @elseif($transaction->type == 'expense')
                                <span class="badge bg-danger fs-6">ব্যয়</span>
                            @else
                                <span class="badge bg-primary fs-6">ট্রান্সফার</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="display-6 fw-bold {{ $transaction->type == 'income' ? 'text-success' : ($transaction->type == 'expense' ? 'text-danger' : 'text-primary') }}">
                            @if($transaction->type == 'income') +@endif
                            @if($transaction->type == 'expense') -@endif
                            ৳{{ number_format($transaction->amount, 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- লেনদেন বিবরণ -->
    <div class="card mb-3">
        <div class="card-header py-2">
            <h5 class="mb-0 small">হিসাব তথ্য</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-6">
                    <div class="text-muted small">
                        @if($transaction->type == 'transfer')
                            উৎস হিসাব
                        @else
                            হিসাব
                        @endif
                    </div>
                    <div class="fw-medium">{{ $transaction->account->name }}</div>
                </div>
                
                @if($transaction->type == 'transfer')
                <div class="col-6">
                    <div class="text-muted small">গন্তব্য হিসাব</div>
                    <div class="fw-medium">{{ $transaction->transferToAccount->name }}</div>
                </div>
                @endif
                
                @if($transaction->category)
                <div class="col-6">
                    <div class="text-muted small">বিভাগ</div>
                    <div class="fw-medium">{{ $transaction->category->name }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($transaction->note || $transaction->attachment)
    <!-- অতিরিক্ত তথ্য -->
    <div class="card mb-3">
        <div class="card-header py-2">
            <h5 class="mb-0 small">অতিরিক্ত তথ্য</h5>
        </div>
        <div class="card-body">
            @if($transaction->note)
            <div class="mb-3">
                <div class="text-muted small">নোট</div>
                <div>{{ $transaction->note }}</div>
            </div>
            @endif
            
            @if($transaction->attachment)
            <div>
                <div class="text-muted small mb-2">সংযুক্তি</div>
                @php
                    $extension = pathinfo($transaction->attachment, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                @endphp
                
                @if($isImage)
                    <a href="{{ Storage::url($transaction->attachment) }}" target="_blank" class="d-block">
                        <img src="{{ Storage::url($transaction->attachment) }}" alt="লেনদেন সংযুক্তি" class="img-fluid rounded border">
                    </a>
                @else
                    <a href="{{ Storage::url($transaction->attachment) }}" target="_blank" class="btn btn-light btn-sm">
                        <i class="fas fa-download me-1"></i> সংযুক্তি ডাউনলোড করুন
                    </a>
                @endif
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- তারিখ তথ্য -->
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="d-flex justify-content-between text-muted small">
                <span>তৈরি: {{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                <span>আপডেট: {{ $transaction->updated_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection 