@extends('layouts.app')

@section('title', $account->name . ' - হিসাব বিবরণ')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">হিসাব বিবরণ</h4>
            <div>
                <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> নতুন লেনদেন যোগ করুন
                </a>
                <a href="{{ route('accounts.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left"></i> সকল হিসাব
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $account->name }}</h5>
                    <span class="badge bg-light text-dark">{{ $account->type }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>বর্তমান ব্যালেন্স:</strong></p>
                            <h2 class="mb-4">{{ number_format($account->current_balance, 2) }} টাকা</h2>
                            
                            <p class="mb-2"><strong>প্রাথমিক ব্যালেন্স:</strong></p>
                            <h5 class="mb-4 text-muted">{{ number_format($account->initial_balance, 2) }} টাকা</h5>
                        </div>
                        <div class="col-md-6">
                            @if($account->account_number)
                            <p class="mb-2"><strong>হিসাব নম্বর:</strong> {{ $account->account_number }}</p>
                            @endif
                            
                            @if($account->bank_name)
                            <p class="mb-2"><strong>ব্যাংক:</strong> {{ $account->bank_name }}</p>
                            @endif
                            
                            @if($account->branch)
                            <p class="mb-2"><strong>শাখা:</strong> {{ $account->branch }}</p>
                            @endif
                            
                            <p class="mb-2"><strong>তৈরি হয়েছে:</strong> {{ $account->created_at->format('d M, Y') }}</p>
                            
                            @if($account->description)
                            <p class="mb-2 mt-3"><strong>বিবরণ:</strong></p>
                            <p class="text-muted">{{ $account->description }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('accounts.edit', $account) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-pencil"></i> সম্পাদনা করুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">আয়</h5>
                </div>
                <div class="card-body text-center">
                    <h3>{{ number_format($account->transactions()->where('type', 'income')->sum('amount'), 2) }} টাকা</h3>
                    <p class="text-muted">মোট আয়</p>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">ব্যয়</h5>
                </div>
                <div class="card-body text-center">
                    <h3>{{ number_format($account->transactions()->where('type', 'expense')->sum('amount'), 2) }} টাকা</h3>
                    <p class="text-muted">মোট ব্যয়</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">সাম্প্রতিক লেনদেন</h5>
        </div>
        <div class="card-body">
            @if($transactions->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-money-bill text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">কোনো লেনদেন নেই</h5>
                    <p class="text-muted">এই হিসাবে কোনো লেনদেন রেকর্ড করা হয়নি</p>
                    <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus-circle"></i> লেনদেন যোগ করুন
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>তারিখ</th>
                                <th>বিবরণ</th>
                                <th>ধরন</th>
                                <th>বিভাগ</th>
                                <th class="text-end">পরিমাণ</th>
                                <th class="text-center">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->date->format('d M, Y') }}</td>
                                <td>{{ $transaction->description }}</td>
                                <td>
                                    @if($transaction->type == 'income')
                                        <span class="badge text-bg-success">আয়</span>
                                    @else
                                        <span class="badge text-bg-danger">ব্যয়</span>
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->category)
                                        <span class="badge" style="background-color: {{ $transaction->category->color }}">
                                            {{ $transaction->category->name }}
                                        </span>
                                    @else
                                        <span class="badge text-bg-secondary">ক্যাটাগরি নেই</span>
                                    @endif
                                </td>
                                <td class="text-end {{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($transaction->amount, 2) }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                        data-bs-toggle="modal" data-bs-target="#deleteTransactionModal{{ $transaction->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Delete Transaction Modal -->
                            <div class="modal fade" id="deleteTransactionModal{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">লেনদেন মুছে ফেলতে নিশ্চিত করুন</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            আপনি কি নিশ্চিত যে আপনি এই লেনদেনটি মুছে ফেলতে চান?<br>
                                            এই পদক্ষেপটি হিসাবের ব্যালেন্স পরিবর্তন করবে এবং পূর্বাবস্থায় ফেরানো যাবে না।
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">মুছে ফেলুন</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 