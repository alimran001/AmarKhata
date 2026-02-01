@extends('layouts.app')

@section('title', 'লোন')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">লোন তালিকা</h2>
        <a href="{{ route('loans.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> নতুন লোন
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- ফিল্টার সেকশন -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('loans.index') }}" method="GET">
                <div class="row g-2">
                    <div class="col-6">
                        <label for="type" class="form-label small">ধরণ</label>
                        <select name="type" id="type" class="form-select form-select-sm">
                            <option value="">সব ধরণ</option>
                            <option value="Given" {{ request('type') == 'Given' ? 'selected' : '' }}>দেওয়া হয়েছে</option>
                            <option value="Taken" {{ request('type') == 'Taken' ? 'selected' : '' }}>নেওয়া হয়েছে</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="is_settled" class="form-label small">স্ট্যাটাস</label>
                        <select name="is_settled" id="is_settled" class="form-select form-select-sm">
                            <option value="">সব স্ট্যাটাস</option>
                            <option value="0" {{ request('is_settled') === '0' ? 'selected' : '' }}>বাকি আছে</option>
                            <option value="1" {{ request('is_settled') === '1' ? 'selected' : '' }}>শোধ হয়েছে</option>
                        </select>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-filter me-1"></i> ফিল্টার
                            </button>
                            <a href="{{ route('loans.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-redo me-1"></i> রিসেট
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- লোন তালিকা -->
    <div class="card">
        @if(isset($loans) && count($loans) > 0)
            <div class="list-group list-group-flush">
                @foreach($loans as $loan)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">{{ $loan->person_name }}</h6>
                                @if($loan->due_date)
                                    <small class="text-muted">শোধের তারিখ: {{ $loan->due_date->format('d/m/Y') }}</small>
                                @endif
                            </div>
                            <span class="badge {{ $loan->type == 'Given' ? 'bg-primary' : 'bg-info' }}">
                                {{ $loan->type == 'Given' ? 'দিয়েছি' : 'নিয়েছি' }}
                            </span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <div class="fw-medium">৳ {{ number_format($loan->amount, 2) }}</div>
                                @if($loan->remaining < $loan->amount)
                                    <small class="text-success">বাকি: ৳ {{ number_format($loan->remaining, 2) }}</small>
                                @endif
                            </div>
                            <span class="badge {{ $loan->is_settled ? 'bg-success' : 'bg-warning' }}">
                                {{ $loan->is_settled ? 'শোধ হয়েছে' : 'বাকি আছে' }}
                            </span>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                <i class="fas fa-eye me-1"></i> বিস্তারিত
                            </a>
                            <a href="{{ route('loans.edit', $loan) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                <i class="fas fa-edit me-1"></i> এডিট
                            </a>
                            <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100" 
                                        onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই লোন মুছতে চান?')">
                                    <i class="fas fa-trash me-1"></i> মুছুন
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="p-3 border-top">
                {{ $loans->links() }}
            </div>
        @else
            <div class="card-body text-center py-5">
                <p class="text-muted mb-3">এখনো কোন লোন যোগ করা হয়নি</p>
                <a href="{{ route('loans.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> নতুন লোন যোগ করুন
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 