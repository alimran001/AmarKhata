@extends('layouts.app')

@section('title', 'আমার হিসাব')

@section('content')
<div class="container py-2">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">হিসাব তালিকা</h5>
            <a href="{{ route('accounts.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> নতুন হিসাব
            </a>
        </div>
    </div>

    <div class="row g-2">
        @if($accounts->isEmpty())
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-university text-muted" style="font-size: 2rem;"></i>
                        <h6 class="mt-2">কোনো হিসাব নেই</h6>
                        <p class="text-muted small">আপনার প্রথম হিসাব তৈরি করুন</p>
                        <a href="{{ route('accounts.create') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-plus-circle"></i> হিসাব তৈরি করুন
                        </a>
                    </div>
                </div>
            </div>
        @else
            @foreach($accounts as $account)
            <div class="col-md-6 col-lg-4 mb-2">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ $account->name }}</h6>
                        <span class="badge bg-secondary small">{{ $account->type }}</span>
                    </div>
                    <div class="card-body py-2">
                        <h5 class="mb-2">{{ number_format($account->current_balance, 2) }} টাকা</h5>
                        
                        <div class="small">
                            @if($account->account_number)
                            <p class="mb-1">
                                <strong>হিসাব নম্বর:</strong> {{ $account->account_number }}
                            </p>
                            @endif
                            
                            @if($account->bank_name)
                            <p class="mb-1">
                                <strong>ব্যাংক:</strong> {{ $account->bank_name }}
                            </p>
                            @endif
                            
                            @if($account->branch)
                            <p class="mb-1">
                                <strong>শাখা:</strong> {{ $account->branch }}
                            </p>
                            @endif
                            
                            @if($account->description)
                            <p class="mb-0 text-muted">
                                {{ Str::limit($account->description, 50) }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-white py-2 d-flex justify-content-between">
                        <a href="{{ route('accounts.show', $account) }}" class="btn btn-sm btn-outline-primary py-1 px-2">
                            <i class="fas fa-eye"></i> দেখুন
                        </a>
                        <div>
                            <a href="{{ route('accounts.edit', $account) }}" class="btn btn-sm btn-outline-secondary py-1 px-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" 
                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $account->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $account->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $account->id }}" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-2">
                            <h6 class="modal-title" id="deleteModalLabel{{ $account->id }}">হিসাব মুছতে নিশ্চিত করুন</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body small">
                            আপনি কি নিশ্চিত যে আপনি <strong>{{ $account->name }}</strong> হিসাবটি মুছে ফেলতে চান?<br>
                            এই পদক্ষেপটি পূর্বাবস্থায় ফেরানো যাবে না।
                        </div>
                        <div class="modal-footer py-1">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                            <form action="{{ route('accounts.destroy', $account) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">মুছুন</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
@endsection 