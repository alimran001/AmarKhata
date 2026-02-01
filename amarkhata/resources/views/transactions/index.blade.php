@extends('layouts.app')

@section('title', 'লেনদেন তালিকা')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">লেনদেন তালিকা</h2>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> নতুন লেনদেন
        </a>
    </div>

    <!-- ফিল্টার সেকশন -->
    <div class="card mb-3">
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 small">লেনদেন ফিল্টার</h5>
            <button class="btn btn-sm btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                <i class="fas fa-filter"></i>
            </button>
        </div>
        <div class="collapse" id="filterCollapse">
            <div class="card-body">
                <form action="{{ route('transactions.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-6 col-md-4">
                            <label for="type" class="form-label small">ধরণ</label>
                            <select name="type" id="type" class="form-select form-select-sm">
                                <option value="">সব ধরণ</option>
                                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>আয়</option>
                                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>ব্যয়</option>
                                <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>ট্রান্সফার</option>
                            </select>
                        </div>
                        
                        <div class="col-6 col-md-4">
                            <label for="account_id" class="form-label small">হিসাব</label>
                            <select name="account_id" id="account_id" class="form-select form-select-sm">
                                <option value="">সব হিসাব</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-6 col-md-4">
                            <label for="category_id" class="form-label small">বিভাগ</label>
                            <select name="category_id" id="category_id" class="form-select form-select-sm">
                                <option value="">সব বিভাগ</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-6 col-md-4">
                            <label for="start_date" class="form-label small">শুরুর তারিখ</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control form-control-sm">
                        </div>
                        
                        <div class="col-6 col-md-4">
                            <label for="end_date" class="form-label small">শেষের তারিখ</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control form-control-sm">
                        </div>
                        
                        <div class="col-12 col-md-4">
                            <label for="search" class="form-label small">অনুসন্ধান</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="নোট দিয়ে খুঁজুন..." class="form-control form-control-sm">
                        </div>
                        
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-filter me-1"></i> ফিল্টার
                                </button>
                                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-redo me-1"></i> রিসেট
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- মোবাইল ভিউ (কার্ড লেআউট) -->
    <div class="d-md-none">
        @if($transactions->count() > 0)
            @foreach($transactions as $transaction)
                <div class="card mb-2">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="small text-muted">{{ $transaction->date->format('d M, Y') }}</div>
                                <div class="fw-medium">
                                    @if($transaction->category)
                                        {{ $transaction->category->name }}
                                    @elseif($transaction->type == 'transfer')
                                        ট্রান্সফার
                                    @endif
                                </div>
                                <div class="small">
                                    @if($transaction->type == 'transfer')
                                        {{ $transaction->account->name }} → {{ $transaction->transferToAccount->name }}
                                    @else
                                        {{ $transaction->account->name }}
                                    @endif
                                </div>
                                @if($transaction->note)
                                    <div class="small text-muted text-truncate" style="max-width: 200px;">{{ $transaction->note }}</div>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="fw-bold {{ $transaction->type == 'income' ? 'text-success' : ($transaction->type == 'expense' ? 'text-danger' : 'text-primary') }}">
                                    @if($transaction->type == 'income') +@endif
                                    @if($transaction->type == 'expense') -@endif
                                    ৳{{ number_format($transaction->amount, 2) }}
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই লেনদেনটি মুছতে চান?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- পেজিনেশন রিমুভ করা হয়েছে -->
        @else
            <div class="card">
                <div class="card-body py-5 text-center text-muted">
                    কোন লেনদেন পাওয়া যায়নি।
                </div>
            </div>
        @endif
    </div>

    <!-- ডেস্কটপ ভিউ (টেবিল লেআউট) -->
    <div class="d-none d-md-block">
        <div class="card">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>তারিখ</th>
                                <th>ধরণ</th>
                                <th>বিভাগ</th>
                                <th>হিসাব</th>
                                <th>পরিমাণ</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($transaction->type == 'income')
                                            <span class="badge bg-success">আয়</span>
                                        @elseif($transaction->type == 'expense')
                                            <span class="badge bg-danger">ব্যয়</span>
                                        @else
                                            <span class="badge bg-primary">ট্রান্সফার</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->category)
                                            {{ $transaction->category->name }}
                                        @elseif($transaction->type == 'transfer')
                                            ট্রান্সফার
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->type == 'transfer')
                                            {{ $transaction->account->name }} → {{ $transaction->transferToAccount->name }}
                                        @else
                                            {{ $transaction->account->name }}
                                        @endif
                                    </td>
                                    <td class="{{ $transaction->type == 'income' ? 'text-success' : ($transaction->type == 'expense' ? 'text-danger' : 'text-primary') }} fw-bold">
                                        ৳{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই লেনদেনটি মুছতে চান?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- পেজিনেশন রিমুভ করা হয়েছে -->
            @else
                <div class="card-body py-5 text-center text-muted">
                    কোন লেনদেন পাওয়া যায়নি।
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* পেজিনেশন স্টাইল রিমুভ করা হয়েছে */
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 0.75rem 1rem;
    }
    
    .small.text-muted {
        font-size: 0.8rem;
    }
</style>
@endpush
@endsection 