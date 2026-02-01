@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h5 class="mb-0 fw-medium">{{ app()->make('App\Services\TranslationService')->translate('Dashboard') }}</h5>
            <small class="text-muted fs-8">{{ __('বর্তমান মাস') }}: {{ now()->locale('bn')->format('F Y') }}</small>
        </div>

        
    </div>
    
    <!-- কুইক ট্রানজেকশন মোডাল -->
    @include('transactions.quick_add')
    
    <!-- Quick Summary Cards -->
    <div class="row g-1 mb-2">
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-1 p-md-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted fs-8">{{ __('নগদ ক্যাশ টাকা') }}</div>
                            <div class="fs-6 fw-medium mb-0">৳ {{ number_format($cashInHandBalance, 2) }}</div>
                        </div>
                        <div class="dashboard-icon">
                            <i class="fas fa-money-bill-wave text-success fa-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-1 p-md-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted fs-8">{{ __('মাসিক আয়') }}</div>
                            <div class="fs-6 fw-medium mb-0 income-text">৳ {{ number_format($totalIncome, 2) }}</div>
                        </div>
                        <div class="dashboard-icon">
                            <i class="fas fa-arrow-circle-up income-text fa-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-1 p-md-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted fs-8">{{ __('মাসিক ব্যয়') }}</div>
                            <div class="fs-6 fw-medium mb-0 expense-text">৳ {{ number_format($totalExpense, 2) }}</div>
                        </div>
                        <div class="dashboard-icon">
                            <i class="fas fa-arrow-circle-down expense-text fa-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-1 p-md-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted fs-8">{{ __('মাসিক সঞ্চয়') }}</div>
                            <div class="fs-6 fw-medium mb-0 {{ ($totalIncome - $totalExpense) >= 0 ? 'text-success' : 'text-danger' }}">
                                ৳ {{ number_format($totalIncome - $totalExpense, 2) }}
                            </div>
                        </div>
                        <div class="dashboard-icon">
                            <i class="fas fa-piggy-bank {{ ($totalIncome - $totalExpense) >= 0 ? 'text-success' : 'text-danger' }} fa-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-1 p-md-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted fs-8">{{ __('Net Loans') }}</div>
                            <div class="fs-6 fw-medium mb-0 loan-text">৳ {{ number_format($totalLoanGiven - $totalLoanTaken, 2) }}</div>
                        </div>
                        <div class="dashboard-icon">
                            <i class="fas fa-hand-holding-usd loan-text fa-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row g-1 mb-2">
        <div class="col-12 col-md-8">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header py-1 bg-transparent border-bottom-0">
                    <h6 class="mb-0 text-muted fw-medium fs-8">সাপ্তাহিক আয় ও ব্যয়</h6>
                </div>
                <div class="card-body pt-0 p-1 p-md-2">
                    <div class="chart-container" style="position: relative; height: 200px;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header py-1 bg-transparent border-bottom-0">
                    <h6 class="mb-0 text-muted fw-medium fs-8">বিভাগ অনুযায়ী ব্যয়</h6>
                </div>
                <div class="card-body pt-0 p-1 p-md-2">
                    <div class="chart-container" style="position: relative; height: 200px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Accounts & Quick Add -->
    <div class="row g-1">
        <div class="col-12 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header py-1 d-flex justify-content-between align-items-center bg-transparent">
                    <h6 class="mb-0 text-muted fw-medium fs-8">আমার সব হিসাব</h6>
                    <a href="{{ route('accounts.index') }}" class="btn btn-sm btn-outline-primary rounded-circle p-1">
                        <i class="fas fa-external-link-alt fa-xs"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($accounts as $account)
                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-1 border-0 border-bottom">
                                <div>
                                    @if($account->type == 'Cash')
                                        <i class="fas fa-money-bill-wave text-success me-1 fa-xs"></i>
                                    @elseif($account->type == 'Bank')
                                        <i class="fas fa-university text-primary me-1 fa-xs"></i>
                                    @else
                                        <i class="fas fa-mobile-alt text-info me-1 fa-xs"></i>
                                    @endif
                                    <span class="fs-8 fw-medium">{{ $account->name }}</span>
                                </div>
                                <span class="badge bg-light text-dark fs-8 fw-medium">৳ {{ number_format($account->current_balance, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header py-1 bg-transparent">
                    <h6 class="mb-0 text-muted fw-medium fs-8">আজকের লেনদেন</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill" id="todayTransactionTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fs-8 py-1" id="income-tab" data-bs-toggle="tab" data-bs-target="#income-tab-pane" type="button" role="tab" aria-controls="income-tab-pane" aria-selected="true">আয়</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fs-8 py-1" id="expense-tab" data-bs-toggle="tab" data-bs-target="#expense-tab-pane" type="button" role="tab" aria-controls="expense-tab-pane" aria-selected="false">ব্যয়</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="todayTransactionTabContent">
                        <div class="tab-pane fade show active" id="income-tab-pane" role="tabpanel" aria-labelledby="income-tab" tabindex="0">
                            <div class="list-group list-group-flush">
                                @php
                                    $todayIncomes = App\Models\Transaction::where('user_id', Auth::id())
                                        ->where('type', 'income')
                                        ->whereDate('date', now()->toDateString())
                                        ->with(['category', 'account'])
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                    
                                    $todayTotalIncome = $todayIncomes->sum('amount');
                                @endphp
                                
                                @if($todayTotalIncome > 0)
                                    <div class="p-2 bg-light border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fs-8 fw-medium">আজকের মোট আয়</span>
                                            <span class="badge bg-success fs-8">৳ {{ number_format($todayTotalIncome, 2) }}</span>
                                        </div>
                                    </div>
                                @endif
                                
                                @forelse($todayIncomes as $income)
                                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 border-0 border-bottom">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <div class="transaction-icon bg-success-subtle me-2">
                                                    <i class="fas {{ $income->category->icon ?? 'fa-arrow-up' }} text-success fa-xs"></i>
                                                </div>
                                                <span class="fs-8 fw-medium">{{ $income->category->name ?? 'অবিভাজিত' }}</span>
                                            </div>
                                            <small class="d-block text-muted fs-8">{{ Str::limit($income->note, 20) ?: 'কোন বিবরণ নেই' }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-success text-white fs-8 fw-medium">৳ {{ number_format($income->amount, 2) }}</span>
                                            <small class="d-block text-muted fs-8">{{ $income->account->name }}</small>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-3 text-center empty-state">
                                        <div class="empty-icon mb-2">
                                            <i class="fas fa-arrow-circle-up text-success-subtle"></i>
                                        </div>
                                        <p class="text-muted fs-8 mb-0">আজ কোন আয় নেই</p>
                                        <button type="button" class="btn btn-sm btn-outline-success mt-2 fs-8 quick-transaction-btn" data-bs-toggle="modal" data-bs-target="#quickTransactionModal" data-type="income">
                                            <i class="fas fa-plus fa-xs me-1"></i> আয় যোগ করুন
                                        </button>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="tab-pane fade" id="expense-tab-pane" role="tabpanel" aria-labelledby="expense-tab" tabindex="0">
                            <div class="list-group list-group-flush">
                                @php
                                    $todayExpenses = App\Models\Transaction::where('user_id', Auth::id())
                                        ->where('type', 'expense')
                                        ->whereDate('date', now()->toDateString())
                                        ->with(['category', 'account'])
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                    
                                    $todayTotalExpense = $todayExpenses->sum('amount');
                                @endphp
                                
                                @if($todayTotalExpense > 0)
                                    <div class="p-2 bg-light border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fs-8 fw-medium">আজকের মোট ব্যয়</span>
                                            <span class="badge bg-danger fs-8">৳ {{ number_format($todayTotalExpense, 2) }}</span>
                                        </div>
                        </div>
                                @endif
                                
                                @forelse($todayExpenses as $expense)
                                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 border-0 border-bottom">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <div class="transaction-icon bg-danger-subtle me-2">
                                                    <i class="fas {{ $expense->category->icon ?? 'fa-arrow-down' }} text-danger fa-xs"></i>
                                                </div>
                                                <span class="fs-8 fw-medium">{{ $expense->category->name ?? 'অবিভাজিত' }}</span>
                                            </div>
                                            <small class="d-block text-muted fs-8">{{ Str::limit($expense->note, 20) ?: 'কোন বিবরণ নেই' }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-danger text-white fs-8 fw-medium">৳ {{ number_format($expense->amount, 2) }}</span>
                                            <small class="d-block text-muted fs-8">{{ $expense->account->name }}</small>
                        </div>
                        </div>
                                @empty
                                    <div class="p-3 text-center empty-state">
                                        <div class="empty-icon mb-2">
                                            <i class="fas fa-arrow-circle-down text-danger-subtle"></i>
                        </div>
                                        <p class="text-muted fs-8 mb-0">আজ কোন ব্যয় নেই</p>
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2 fs-8 quick-transaction-btn" data-bs-toggle="modal" data-bs-target="#quickTransactionModal" data-type="expense">
                                            <i class="fas fa-plus fa-xs me-1"></i> ব্যয় যোগ করুন
                            </button>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-2 bg-light border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-8 fw-medium">আজকের ব্যালেন্স</span>
                        <span class="badge {{ ($todayTotalIncome - $todayTotalExpense) >= 0 ? 'bg-success' : 'bg-danger' }} fs-8">
                            ৳ {{ number_format($todayTotalIncome - $todayTotalExpense, 2) }}
                        </span>
                    </div>
                </div><br /><br>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fs-7 {
        font-size: 0.8rem !important;
    }
    
    .fs-8 {
        font-size: 0.7rem !important;
    }
    
    .dashboard-icon {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.05);
        font-size: 0.9rem;
    }
    
    .card {
        transition: all 0.2s ease;
        border-radius: 0.4rem;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.12) !important;
    }
    
    .list-group-item {
        transition: background-color 0.2s ease;
    }
    
    .list-group-item:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .income-text {
        color: #28a745;
    }
    
    .expense-text {
        color: #dc3545;
    }
    
    .loan-text {
        color: #6c757d;
    }
    
    /* Transaction icon styles */
    .transaction-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-success-subtle {
        background-color: rgba(40, 167, 69, 0.15);
    }
    
    .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.15);
    }
    
    .text-success-subtle {
        color: rgba(40, 167, 69, 0.7);
    }
    
    .text-danger-subtle {
        color: rgba(220, 53, 69, 0.7);
    }
    
    /* Empty state styles */
    .empty-state {
        padding: 1.5rem 1rem;
    }
    
    .empty-icon {
        font-size: 2rem;
        opacity: 0.5;
    }
    
    /* Nav tabs custom styles */
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 2px solid transparent;
    }
    
    .nav-tabs .nav-link.active {
        color: #FE5B56;
        border-bottom: 2px solid #FE5B56;
        background-color: transparent;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link:hover:not(.active) {
        border-bottom: 2px solid #dee2e6;
    }
    
    /* ডার্ক মোড সাপোর্ট */
    body.dark-mode .dashboard-icon {
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    body.dark-mode .list-group-item:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }
    
    body.dark-mode .bg-success-subtle {
        background-color: rgba(40, 167, 69, 0.25);
    }
    
    body.dark-mode .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.25);
    }
    
    /* ছোট স্ক্রিনের জন্য অতিরিক্ত স্টাইল */
    @media (max-width: 576px) {
        .chart-container {
            height: 180px !important;
        }
        
        .dashboard-icon {
            width: 24px;
            height: 24px;
            font-size: 0.8rem;
        }
        
        .fs-6 {
            font-size: 0.85rem !important;
        }
        
        .transaction-icon {
            width: 20px;
            height: 20px;
        }
        
        .empty-icon {
            font-size: 1.5rem;
        }
        
        .empty-state {
            padding: 1rem 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Add a console log to check if this script is running
    console.log('Dashboard script initialized');
    
    // Initialize charts when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing charts...');
    
    // Weekly chart
    const weeklyData = @json($weeklyData);
        console.log('Weekly data:', weeklyData);
        
        const weeklyCtx = document.getElementById('weeklyChart');
        if (weeklyCtx) {
            console.log('Weekly chart canvas found');
            new Chart(weeklyCtx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: weeklyData.labels,
            datasets: [
                {
                            label: 'আয়',
                    backgroundColor: '#E4C306',
                    borderColor: '#E4C306',
                    data: weeklyData.income
                },
                {
                            label: 'ব্যয়',
                    backgroundColor: '#FE5B56',
                    borderColor: '#FE5B56',
                    data: weeklyData.expense
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                                    size: 9
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                                    size: 9
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                                boxWidth: 8,
                        font: {
                                    size: 9
                                }
                            }
                        }
                    }
                }
            });
        } else {
            console.error('Weekly chart canvas not found');
        }
    
    // Category chart
    const categoryData = @json($expenseByCategory);
        console.log('Category data:', categoryData);
        
        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx) {
            console.log('Category chart canvas found');
            new Chart(categoryCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: categoryData.labels,
            datasets: [{
                data: categoryData.data,
                backgroundColor: categoryData.colors,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                                boxWidth: 8,
                        font: {
                                    size: 9
                                }
                            }
                        }
                    }
                }
            });
        } else {
            console.error('Category chart canvas not found');
        }
    });

    // মোডাল বাটন ক্লিক ইভেন্ট হ্যান্ডলিং
    document.addEventListener('DOMContentLoaded', function() {
        // কুইক ট্রানজেকশন বাটন ইভেন্ট লিসেনার - ডুপ্লিকেট ইভেন্ট এড়াতে
        const quickAddButtons = document.querySelectorAll('[data-bs-target="#quickTransactionModal"]');
        if (quickAddButtons.length > 0) {
            // সব বাটন থেকে আগের ইভেন্ট লিসেনার রিমুভ করা
            quickAddButtons.forEach(button => {
                const newButton = button.cloneNode(true);
                button.parentNode.replaceChild(newButton, button);
            });
            
            // নতুন ইভেন্ট লিসেনার যোগ করা
            document.querySelectorAll('[data-bs-target="#quickTransactionModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const type = this.getAttribute('data-type');
                    console.log('Quick add button clicked with type:', type);
                    
                    // টাইটেল সেট করা
                    const modalTitle = document.getElementById('modalTitle');
                    if (modalTitle) {
                        const title = type === 'income' ? 'আয় যোগ করুন' : 'ব্যয় যোগ করুন';
                        modalTitle.textContent = title;
                    }
                    
                    const transactionType = document.getElementById('transactionType');
                    if (transactionType) {
                        transactionType.value = type;
                    }
                    
                    // ফর্ম রিসেট
                    const quickTransactionForm = document.getElementById('quickTransactionForm');
                    if (quickTransactionForm) {
                        quickTransactionForm.reset();
                    }
                    
                    const transactionDate = document.getElementById('transaction_date');
                    if (transactionDate) {
                        transactionDate.value = getFormattedDate();
                    }
                    
                    // বিভাগ লোড করা
                    if (typeof loadCategories === 'function') {
                        loadCategories(type);
                    }
                });
            });
        }
    });
    
    // আজকের তারিখ ফরম্যাট করার ফাংশন
    function getFormattedDate() {
        const today = new Date();
        const year = today.getFullYear();
        let month = today.getMonth() + 1;
        let day = today.getDate();
        
        month = month < 10 ? '0' + month : month;
        day = day < 10 ? '0' + day : day;
        
        return `${year}-${month}-${day}`;
    }
</script>
@endpush 