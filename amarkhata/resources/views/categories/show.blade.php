@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- ক্যাটেগরি হেডার -->
            <div class="card shadow-sm mb-3">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-tag text-primary me-2"></i>
                                {{ $category->name }}
                            </h5>
                            <small class="text-muted">{{ $category->type == 'income' ? 'আয়' : 'ব্যয়' }}</small>
                        </div>
                        <div>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-light border me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- লেনদেন লিস্ট -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">লেনদেন তালিকা</h6>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> ফিল্টার
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('categories.show', [$category, 'filter' => 'today']) }}">আজ</a></li>
                                <li><a class="dropdown-item" href="{{ route('categories.show', [$category, 'filter' => 'week']) }}">এই সপ্তাহ</a></li>
                                <li><a class="dropdown-item" href="{{ route('categories.show', [$category, 'filter' => 'month']) }}">এই মাস</a></li>
                                <li><a class="dropdown-item" href="{{ route('categories.show', [$category, 'filter' => 'year']) }}">এই বছর</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($transactions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($transactions as $transaction)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $transaction->description }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $transaction->date->format('d M, Y') }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <h6 class="mb-1 {{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                                {{ $transaction->type == 'income' ? '+' : '-' }} ৳{{ number_format($transaction->amount, 2) }}
                                            </h6>
                                            <small class="text-muted">{{ $transaction->account->name }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- পেজিনেশন -->
                        <div class="p-3">
                            {{ $transactions->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <img src="{{ asset('images/no-data.svg') }}" alt="No Data" class="mb-3" style="width: 120px;">
                            <h6 class="text-muted">কোন লেনদেন নেই</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* মোবাইল অপটিমাইজেশন */
@media (max-width: 576px) {
    .container {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    .card {
        border-radius: 10px;
    }
    
    .list-group-item {
        padding: 12px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    h6 {
        font-size: 0.9rem;
    }
    
    small {
        font-size: 0.75rem;
    }
}

/* ডার্ক মোড সাপোর্ট */
body.dark-mode .card {
    background-color: #2d2d2d;
    border-color: #3d3d3d;
}

body.dark-mode .card-header {
    background-color: #2d2d2d !important;
    border-color: #3d3d3d;
}

body.dark-mode .list-group-item {
    background-color: #2d2d2d;
    border-color: #3d3d3d;
}

body.dark-mode .btn-light {
    background-color: #3d3d3d;
    border-color: #4d4d4d;
    color: #ffffff;
}

body.dark-mode .dropdown-menu {
    background-color: #2d2d2d;
    border-color: #3d3d3d;
}

body.dark-mode .dropdown-item {
    color: #ffffff;
}

body.dark-mode .dropdown-item:hover {
    background-color: #3d3d3d;
}
</style>
@endsection 