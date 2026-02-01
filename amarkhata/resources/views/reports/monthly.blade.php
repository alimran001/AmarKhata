@extends('layouts.app')

@section('title', 'মাসিক রিপোর্ট')

@section('content')
<div class="container py-2">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
                    <h5 class="mb-0 fs-6">মাসিক রিপোর্ট</h5>
                    <div>
                        <a href="{{ route('reports.download', ['type' => 'monthly', 'year' => $year, 'month' => $month]) }}" class="btn btn-sm btn-light">
                            <i class="fas fa-download me-1"></i> ডাউনলোড পিডিএফ
                        </a>
                    </div>
                </div>
                <div class="card-body p-2 p-sm-3">
                    <form action="{{ route('reports.monthly') }}" method="GET" class="mb-3">
                        <div class="row g-2">
                            <div class="col-7 col-md-5">
                                <select name="month" class="form-select form-select-sm">
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-5 col-md-5">
                                <select name="year" class="form-select form-select-sm">
                                    @foreach(range(date('Y') - 5, date('Y')) as $y)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-2 mt-2 mt-md-0">
                                <button type="submit" class="btn btn-sm btn-primary w-100">দেখুন</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <div class="card border-0 text-bg-success">
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title mb-1">মোট আয়</h6>
                                    <h5 class="mb-0">{{ number_format($totalIncome, 2) }} ৳</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 text-bg-danger">
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title mb-1">মোট ব্যয়</h6>
                                    <h5 class="mb-0">{{ number_format($totalExpense, 2) }} ৳</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 {{ $balance >= 0 ? 'text-bg-info' : 'text-bg-warning' }}">
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title mb-1">ব্যালেন্স</h6>
                                    <h5 class="mb-0">{{ number_format($balance, 2) }} ৳</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ঋণের তথ্য সেকশন -->
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header py-2 bg-light">
                            <h6 class="mb-0">ঋণের হিসাব</h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header py-2 bg-light">
                                            <h6 class="mb-0 small fw-bold">প্রদত্ত ঋণ</h6>
                                        </div>
                                        <div class="card-body p-2">
                                            <table class="table table-sm table-bordered mb-0">
                                                <tr>
                                                    <td>মোট ঋণের পরিমাণ</td>
                                                    <td class="text-end fw-bold">{{ number_format($givenLoans['total'], 2) }} ৳</td>
                                                </tr>
                                                <tr>
                                                    <td>সর্বমোট পরিশোধ</td>
                                                    <td class="text-end fw-bold">{{ number_format($givenLoans['paid'], 2) }} ৳</td>
                                                </tr>
                                                @if(isset($givenLoans['paid_in_range']))
                                                <tr>
                                                    <td>এই মাসে পরিশোধ</td>
                                                    <td class="text-end fw-bold text-success">{{ number_format($givenLoans['paid_in_range'], 2) }} ৳</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td>অবশিষ্ট পরিমাণ</td>
                                                    <td class="text-end fw-bold">{{ number_format($givenLoans['remaining'], 2) }} ৳</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header py-2 bg-light">
                                            <h6 class="mb-0 small fw-bold">গৃহীত ঋণ</h6>
                                        </div>
                                        <div class="card-body p-2">
                                            <table class="table table-sm table-bordered mb-0">
                                                <tr>
                                                    <td>মোট ঋণের পরিমাণ</td>
                                                    <td class="text-end fw-bold">{{ number_format($takenLoans['total'], 2) }} ৳</td>
                                                </tr>
                                                <tr>
                                                    <td>সর্বমোট পরিশোধ</td>
                                                    <td class="text-end fw-bold">{{ number_format($takenLoans['paid'], 2) }} ৳</td>
                                                </tr>
                                                @if(isset($takenLoans['paid_in_range']))
                                                <tr>
                                                    <td>এই মাসে পরিশোধ</td>
                                                    <td class="text-end fw-bold text-success">{{ number_format($takenLoans['paid_in_range'], 2) }} ৳</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td>অবশিষ্ট পরিমাণ</td>
                                                    <td class="text-end fw-bold">{{ number_format($takenLoans['remaining'], 2) }} ৳</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- হিসাব বিবরণ সেকশন -->
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header py-2 bg-light">
                            <h6 class="mb-0">হিসাব বিবরণ ({{ $monthName }} শেষে)</h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="mb-2">
                                <h6 class="border-bottom pb-1 mb-2 small fw-bold">হিসাব টাইপ অনুযায়ী মোট</h6>
                                <div class="row g-2">
                                    @foreach($balanceByType as $type => $amount)
                                    <div class="col-6 col-md-4">
                                        <div class="d-flex justify-content-between small">
                                            <span>{{ $type }}</span>
                                            <span class="fw-bold">{{ number_format($amount, 2) }} ৳</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <h6 class="border-bottom pb-1 mb-2 small fw-bold">সমস্ত হিসাব বিবরণ</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover mb-1">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="small">হিসাবের নাম</th>
                                            <th class="small">টাইপ</th>
                                            <th class="text-end small">ব্যালেন্স</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small">
                                        @foreach($accountBalances as $account)
                                        <tr>
                                            <td>{{ $account->name }}</td>
                                            <td>{{ $account->type }}</td>
                                            <td class="text-end">{{ number_format($account->month_end_balance, 2) }} ৳</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr class="fw-bold small">
                                            <td colspan="2">মোট ব্যালেন্স</td>
                                            <td class="text-end">{{ number_format($accountBalances->sum('month_end_balance'), 2) }} ৳</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header py-2 bg-light">
                                    <h6 class="mb-0 small fw-bold">খরচের বিভাগ</h6>
                                </div>
                                <div class="card-body p-2">
                                    @if($categoryExpense->isEmpty())
                                        <p class="text-center small">কোন খরচ নেই</p>
                                    @else
                                        <div class="chart-container position-relative" style="height:40vh; max-height:250px;">
                                            <canvas id="expenseChart"></canvas>
                                        </div>
                                        <div class="mt-2 small">
                                            @foreach($categoryExpense as $expense)
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div>
                                                        <span class="badge rounded-pill" style="background-color: {{ $expense->color }}">
                                                            &nbsp;
                                                        </span>
                                                        {{ $expense->name }}
                                                    </div>
                                                    <div>{{ number_format($expense->total, 2) }} ৳</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header py-2 bg-light">
                                    <h6 class="mb-0 small fw-bold">আয়ের বিভাগ</h6>
                                </div>
                                <div class="card-body p-2">
                                    @if($categoryIncome->isEmpty())
                                        <p class="text-center small">কোন আয় নেই</p>
                                    @else
                                        <div class="chart-container position-relative" style="height:40vh; max-height:250px;">
                                            <canvas id="incomeChart"></canvas>
                                        </div>
                                        <div class="mt-2 small">
                                            @foreach($categoryIncome as $income)
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div>
                                                        <span class="badge rounded-pill" style="background-color: {{ $income->color }}">
                                                            &nbsp;
                                                        </span>
                                                        {{ $income->name }}
                                                    </div>
                                                    <div>{{ number_format($income->total, 2) }} ৳</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-header py-2 bg-light">
                            <h6 class="mb-0 small fw-bold">দৈনিক আয়-ব্যয়</h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="chart-container position-relative" style="height:35vh; max-height:200px;">
                                <canvas id="dailyChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* মোবাইল প্রথম অপ্টিমাইজেশন */
    @media (max-width: 576px) {
        .card-body {
            padding: 0.5rem !important;
        }
        
        .table-responsive {
            margin-bottom: 0 !important;
        }
        
        .table th, .table td {
            padding: 0.3rem 0.5rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // চার্টের জন্য রেসপন্সিভ কনফিগারেশন
        const chartConfig = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: window.innerWidth > 576, // মোবাইলে লেজেন্ড লুকানো
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        padding: 10,
                        font: {
                            size: 10
                        }
                    }
                },
                tooltip: {
                    bodyFont: {
                        size: 11
                    },
                    titleFont: {
                        size: 11
                    }
                }
            }
        };
        
        @if(!$categoryExpense->isEmpty())
        new Chart(document.getElementById('expenseChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($categoryExpense->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($categoryExpense->pluck('total')) !!},
                    backgroundColor: {!! json_encode($categoryExpense->pluck('color')) !!}
                }]
            },
            options: chartConfig
        });
        @endif
        
        @if(!$categoryIncome->isEmpty())
        new Chart(document.getElementById('incomeChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($categoryIncome->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($categoryIncome->pluck('total')) !!},
                    backgroundColor: {!! json_encode($categoryIncome->pluck('color')) !!}
                }]
            },
            options: chartConfig
        });
        @endif
        
        const days = {!! json_encode(array_values($days)) !!};
        
        new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: days.map(day => day.day),
                datasets: [
                    {
                        label: 'আয়',
                        data: days.map(day => day.income),
                        borderColor: 'rgba(40, 167, 69, 1)',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.1,
                        borderWidth: 2
                    },
                    {
                        label: 'ব্যয়',
                        data: days.map(day => day.expense),
                        borderColor: 'rgba(220, 53, 69, 1)',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.1,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 10,
                            padding: 10,
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush 