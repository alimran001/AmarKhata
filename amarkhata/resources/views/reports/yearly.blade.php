@extends('layouts.app')

@section('title', 'বার্ষিক রিপোর্ট')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">বার্ষিক রিপোর্ট</h5>
                    <div>
                        <a href="{{ route('reports.download', ['type' => 'yearly', 'year' => $year]) }}" class="btn btn-sm btn-light">
                            <i class="bi bi-download"></i> পিডিএফ ডাউনলোড
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.yearly') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-10">
                                <select name="year" class="form-select">
                                    @foreach(range(date('Y') - 5, date('Y')) as $y)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">দেখুন</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">মোট আয়</h5>
                                    <h3>{{ number_format($yearlyTotals['income'], 2) }} টাকা</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-bg-danger">
                                <div class="card-body">
                                    <h5 class="card-title">মোট ব্যয়</h5>
                                    <h3>{{ number_format($yearlyTotals['expense'], 2) }} টাকা</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card {{ $yearlyTotals['balance'] >= 0 ? 'text-bg-info' : 'text-bg-warning' }}">
                                <div class="card-body">
                                    <h5 class="card-title">ব্যালেন্স</h5>
                                    <h3>{{ number_format($yearlyTotals['balance'], 2) }} টাকা</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ঋণের হিসাব সেকশন -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">ঋণের হিসাব</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">প্রদত্ত ঋণ</h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered mb-0">
                                                <tr>
                                                    <td>মোট ঋণের পরিমাণ</td>
                                                    <td class="text-end fw-bold">{{ number_format($givenLoans['total'], 2) }} টাকা</td>
                                                </tr>
                                                <tr>
                                                    <td>পরিশোধিত অংশ</td>
                                                    <td class="text-end fw-bold">{{ number_format($givenLoans['paid'], 2) }} টাকা</td>
                                                </tr>
                                                <tr>
                                                    <td>অবশিষ্ট পরিমাণ</td>
                                                    <td class="text-end fw-bold">{{ number_format($givenLoans['remaining'], 2) }} টাকা</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">গৃহীত ঋণ</h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered mb-0">
                                                <tr>
                                                    <td>মোট ঋণের পরিমাণ</td>
                                                    <td class="text-end fw-bold">{{ number_format($takenLoans['total'], 2) }} টাকা</td>
                                                </tr>
                                                <tr>
                                                    <td>পরিশোধিত অংশ</td>
                                                    <td class="text-end fw-bold">{{ number_format($takenLoans['paid'], 2) }} টাকা</td>
                                                </tr>
                                                <tr>
                                                    <td>অবশিষ্ট পরিমাণ</td>
                                                    <td class="text-end fw-bold">{{ number_format($takenLoans['remaining'], 2) }} টাকা</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">হিসাব বিবরণ</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="border-bottom pb-2">হিসাব টাইপ অনুযায়ী মোট</h6>
                                    <div class="row">
                                        @foreach($balanceByType as $type => $amount)
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex justify-content-between">
                                                <strong>{{ $type }}</strong>
                                                <span>{{ number_format($amount, 2) }} টাকা</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <h6 class="border-bottom pb-2">সমস্ত হিসাব বিবরণ</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>হিসাবের নাম</th>
                                            <th>টাইপ</th>
                                            <th class="text-end">বর্তমান ব্যালেন্স</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($accountBalances as $account)
                                        <tr>
                                            <td>{{ $account->name }}</td>
                                            <td>{{ $account->type }}</td>
                                            <td class="text-end">{{ number_format($account->current_balance, 2) }} টাকা</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="fw-bold">
                                            <td colspan="2">মোট ব্যালেন্স</td>
                                            <td class="text-end">{{ number_format($accountBalances->sum('current_balance'), 2) }} টাকা</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">মাসিক আয়-ব্যয়</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">খরচের বিভাগ</h5>
                                </div>
                                <div class="card-body">
                                    @if($categoryExpense->isEmpty())
                                        <p class="text-center">কোন খরচ নেই</p>
                                    @else
                                        <canvas id="expenseChart" width="400" height="300"></canvas>
                                        <div class="mt-3">
                                            @foreach($categoryExpense as $expense)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <span class="badge rounded-pill" style="background-color: {{ $expense->color }}">
                                                            &nbsp;
                                                        </span>
                                                        {{ $expense->name }}
                                                    </div>
                                                    <div>{{ number_format($expense->total, 2) }} টাকা</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">আয়ের বিভাগ</h5>
                                </div>
                                <div class="card-body">
                                    @if($categoryIncome->isEmpty())
                                        <p class="text-center">কোন আয় নেই</p>
                                    @else
                                        <canvas id="incomeChart" width="400" height="300"></canvas>
                                        <div class="mt-3">
                                            @foreach($categoryIncome as $income)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <span class="badge rounded-pill" style="background-color: {{ $income->color }}">
                                                            &nbsp;
                                                        </span>
                                                        {{ $income->name }}
                                                    </div>
                                                    <div>{{ number_format($income->total, 2) }} টাকা</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">মাসিক বিবরণ</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>মাস</th>
                                            <th class="text-end">আয়</th>
                                            <th class="text-end">ব্যয়</th>
                                            <th class="text-end">ব্যালেন্স</th>
                                            <th class="text-center">বিস্তারিত</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($months as $month)
                                        <tr>
                                            <td>{{ $month['name'] }}</td>
                                            <td class="text-end text-success">{{ number_format($month['income'], 2) }}</td>
                                            <td class="text-end text-danger">{{ number_format($month['expense'], 2) }}</td>
                                            <td class="text-end {{ ($month['income'] - $month['expense'] >= 0) ? 'text-info' : 'text-warning' }}">
                                                {{ number_format($month['income'] - $month['expense'], 2) }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('reports.monthly', ['year' => $year, 'month' => $month['month']]) }}" class="btn btn-sm btn-outline-primary">
                                                    দেখুন
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const months = {!! json_encode(array_values($months)) !!};
        
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: months.map(month => month.name),
                datasets: [
                    {
                        label: 'আয়',
                        data: months.map(month => month.income),
                        backgroundColor: 'rgba(40, 167, 69, 0.5)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'ব্যয়',
                        data: months.map(month => month.expense),
                        backgroundColor: 'rgba(220, 53, 69, 0.5)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
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
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
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
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
        @endif
    });
</script>
@endsection 