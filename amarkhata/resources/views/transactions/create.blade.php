@extends('layouts.app')

@section('title', 'লেনদেন যোগ করুন')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">লেনদেন যোগ করুন</h2>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> লেনদেন তালিকা
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
            <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- লেনদেনের ধরণ -->
                <div class="mb-3">
                    <label for="type" class="form-label">লেনদেনের ধরণ <span class="text-danger">*</span></label>
                    <div class="btn-group w-100" role="group" aria-label="Transaction Type">
                        <input type="radio" class="btn-check" name="type" id="incomeType" value="income" autocomplete="off" required>
                        <label class="btn btn-outline-success" for="incomeType">আয়</label>

                        <input type="radio" class="btn-check" name="type" id="expenseType" value="expense" autocomplete="off">
                        <label class="btn btn-outline-danger" for="expenseType">ব্যয়</label>

                        <input type="radio" class="btn-check" name="type" id="transferType" value="transfer" autocomplete="off">
                        <label class="btn btn-outline-primary" for="transferType">ট্রান্সফার</label>
                    </div>
                </div>

                <!-- হিসাব নির্বাচন -->
                <div class="mb-3">
                    <label for="account_id" class="form-label">যে হিসাব থেকে <span class="text-danger">*</span></label>
                    <select name="account_id" id="account_id" class="form-select" required>
                        <option value="">হিসাব নির্বাচন করুন</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }} (৳ {{ number_format($account->current_balance, 2) }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- ট্রান্সফার হিসাব (শুধুমাত্র ট্রান্সফার টাইপের জন্য) -->
                <div class="mb-3 d-none" id="transfer_to_account_div">
                    <label for="transfer_to_account_id" class="form-label">যে হিসাবে <span class="text-danger">*</span></label>
                    <select name="transfer_to_account_id" id="transfer_to_account_id" class="form-select">
                        <option value="">হিসাব নির্বাচন করুন</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- বিভাগ (শুধুমাত্র আয় এবং ব্যয়ের জন্য) -->
                <div class="mb-3 d-none" id="category_div">
                    <label for="category_id" class="form-label">বিভাগ <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">বিভাগ নির্বাচন করুন</option>
                        <!-- JS দিয়ে পূরণ করা হবে -->
                    </select>
                </div>

                <!-- পরিমাণ -->
                <div class="mb-3">
                    <label for="amount" class="form-label">পরিমাণ <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0.01" required>
                    </div>
                </div>

                <!-- তারিখ -->
                <div class="mb-3">
                    <label for="date" class="form-label">তারিখ <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <!-- নোট -->
                <div class="mb-3">
                    <label for="note" class="form-label">নোট</label>
                    <textarea name="note" id="note" rows="2" class="form-control"></textarea>
                </div>

                <!-- অ্যাটাচমেন্ট -->
                <div class="mb-3">
                    <label for="attachment" class="form-label">অ্যাটাচমেন্ট</label>
                    <input type="file" name="attachment" id="attachment" class="form-control">
                    <div class="form-text">সর্বোচ্চ ফাইল সাইজ: ২MB। অনুমোদিত ফরম্যাট: jpg, png, pdf</div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeInputs = document.querySelectorAll('input[name="type"]');
        const categoryDiv = document.getElementById('category_div');
        const transferToAccountDiv = document.getElementById('transfer_to_account_div');
        const categorySelect = document.getElementById('category_id');
        const transferToAccountSelect = document.getElementById('transfer_to_account_id');
        
        // Categories data
        const expenseCategories = @json($categories);
        const incomeCategories = @json($incomeCategories);
        
        // Handle transaction type change
        typeInputs.forEach(input => {
            input.addEventListener('change', function() {
                const selectedType = this.value;
                
                // Reset selects
                categorySelect.innerHTML = '<option value="">বিভাগ নির্বাচন করুন</option>';
                transferToAccountSelect.value = '';
                
                // Hide all dynamic divs first
                categoryDiv.classList.add('d-none');
                transferToAccountDiv.classList.add('d-none');
                
                if (selectedType === 'expense') {
                    // Show category div
                    categoryDiv.classList.remove('d-none');
                    
                    // Populate with expense categories
                    expenseCategories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                    });
                } else if (selectedType === 'income') {
                    // Show category div
                    categoryDiv.classList.remove('d-none');
                    
                    // Populate with income categories
                    incomeCategories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                    });
                } else if (selectedType === 'transfer') {
                    // Show transfer div
                    transferToAccountDiv.classList.remove('d-none');
                }
            });
        });
        
        // Prevent transferring to the same account
        const accountSelect = document.getElementById('account_id');
        accountSelect.addEventListener('change', function() {
            const selectedAccountId = this.value;
            
            // Reset transfer to account options
            transferToAccountSelect.innerHTML = '<option value="">হিসাব নির্বাচন করুন</option>';
            
            // Add all accounts except the selected one
            @foreach($accounts as $account)
                if ("{{ $account->id }}" !== selectedAccountId) {
                    const option = document.createElement('option');
                    option.value = "{{ $account->id }}";
                    option.textContent = "{{ $account->name }}";
                    transferToAccountSelect.appendChild(option);
                }
            @endforeach
        });
    });
</script>
@endpush
@endsection 