<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>কাস্টম রিপোর্ট</title>
    <style>
        body {
            font-family: 'nikosh', sans-serif;
            line-height: 1.5;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h1, h2, h3, h4 {
            margin-top: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            margin: 0;
            font-size: 16px;
        }
        .summary {
            margin-bottom: 20px;
        }
        .summary-item {
            display: inline-block;
            width: 32%;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .card-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .grid {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        .grid-col-6 {
            width: 46%;
            padding: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>কাস্টম রিপোর্ট</h1>
            <p>{{ $startDate->format('d M, Y') }} - {{ $endDate->format('d M, Y') }}</p>
        </div>
        
        <div class="summary">
            <div class="summary-item">
                <h3>মোট আয়</h3>
                <h2>{{ number_format($totalIncome, 2) }} টাকা</h2>
            </div>
            <div class="summary-item">
                <h3>মোট ব্যয়</h3>
                <h2>{{ number_format($totalExpense, 2) }} টাকা</h2>
            </div>
            <div class="summary-item">
                <h3>ব্যালেন্স</h3>
                <h2>{{ number_format($balance, 2) }} টাকা</h2>
            </div>
        </div>
        
        <div class="section">
            <h3>ঋণের হিসাব</h3>
            <div class="grid">
                <div class="grid-col-6">
                    <div class="card">
                        <div class="card-header">প্রদত্ত ঋণ</div>
                        <table class="table">
                            <tr>
                                <td>মোট ঋণের পরিমাণ</td>
                                <td class="text-right">{{ number_format($givenLoans['total'], 2) }} টাকা</td>
                            </tr>
                            <tr>
                                <td>পরিশোধিত অংশ</td>
                                <td class="text-right">{{ number_format($givenLoans['paid'], 2) }} টাকা</td>
                            </tr>
                            <tr>
                                <td>এই সময়ে পরিশোধ</td>
                                <td class="text-right">{{ number_format($givenLoans['paid_in_range'], 2) }} টাকা</td>
                            </tr>
                            <tr>
                                <td>অবশিষ্ট পরিমাণ</td>
                                <td class="text-right">{{ number_format($givenLoans['remaining'], 2) }} টাকা</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="grid-col-6">
                    <div class="card">
                        <div class="card-header">গৃহীত ঋণ</div>
                        <table class="table">
                            <tr>
                                <td>মোট ঋণের পরিমাণ</td>
                                <td class="text-right">{{ number_format($takenLoans['total'], 2) }} টাকা</td>
                            </tr>
                            <tr>
                                <td>পরিশোধিত অংশ</td>
                                <td class="text-right">{{ number_format($takenLoans['paid'], 2) }} টাকা</td>
                            </tr>
                            <tr>
                                <td>এই সময়ে পরিশোধ</td>
                                <td class="text-right">{{ number_format($takenLoans['paid_in_range'], 2) }} টাকা</td>
                            </tr>
                            <tr>
                                <td>অবশিষ্ট পরিমাণ</td>
                                <td class="text-right">{{ number_format($takenLoans['remaining'], 2) }} টাকা</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <h3>হিসাব বিবরণ</h3>
            
            <h4>হিসাব টাইপ অনুযায়ী মোট</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>টাইপ</th>
                        <th class="text-right">পরিমাণ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($balanceByType as $type => $amount)
                    <tr>
                        <td>{{ $type }}</td>
                        <td class="text-right">{{ number_format($amount, 2) }} টাকা</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>মোট</th>
                        <th class="text-right">{{ number_format($accountBalances->sum('current_balance'), 2) }} টাকা</th>
                    </tr>
                </tfoot>
            </table>
            
            <h4>সমস্ত হিসাব বিবরণ</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>হিসাবের নাম</th>
                        <th>টাইপ</th>
                        <th class="text-right">বর্তমান ব্যালেন্স</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accountBalances as $account)
                    <tr>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->type }}</td>
                        <td class="text-right">{{ number_format($account->current_balance, 2) }} টাকা</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">মোট ব্যালেন্স</th>
                        <th class="text-right">{{ number_format($accountBalances->sum('current_balance'), 2) }} টাকা</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="section">
            <h3>বিভাগ অনুযায়ী ব্যয়</h3>
            @if($categoryExpense->isEmpty())
                <p class="text-center">কোন খরচ নেই</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>বিভাগ</th>
                            <th class="text-right">পরিমাণ</th>
                            <th class="text-right">শতাংশ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryExpense as $expense)
                        <tr>
                            <td>{{ $expense->name }}</td>
                            <td class="text-right">{{ number_format($expense->total, 2) }} টাকা</td>
                            <td class="text-right">{{ number_format(($expense->total / $totalExpense) * 100, 2) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>মোট</th>
                            <th class="text-right">{{ number_format($totalExpense, 2) }} টাকা</th>
                            <th class="text-right">100%</th>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
        
        <div class="section">
            <h3>বিভাগ অনুযায়ী আয়</h3>
            @if($categoryIncome->isEmpty())
                <p class="text-center">কোন আয় নেই</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>বিভাগ</th>
                            <th class="text-right">পরিমাণ</th>
                            <th class="text-right">শতাংশ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryIncome as $income)
                        <tr>
                            <td>{{ $income->name }}</td>
                            <td class="text-right">{{ number_format($income->total, 2) }} টাকা</td>
                            <td class="text-right">{{ number_format(($income->total / $totalIncome) * 100, 2) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>মোট</th>
                            <th class="text-right">{{ number_format($totalIncome, 2) }} টাকা</th>
                            <th class="text-right">100%</th>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
        
        <div class="section">
            <h3>লেনদেন তালিকা</h3>
            @if($transactions->isEmpty())
                <p class="text-center">কোন লেনদেন নেই</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>তারিখ</th>
                            <th>বিবরণ</th>
                            <th>ধরন</th>
                            <th>বিভাগ</th>
                            <th>হিসাব</th>
                            <th class="text-right">পরিমাণ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->date->format('d M, Y') }}</td>
                            <td>{{ $transaction->description }}</td>
                            <td>{{ $transaction->type == 'income' ? 'আয়' : 'ব্যয়' }}</td>
                            <td>{{ $transaction->category->name }}</td>
                            <td>{{ $transaction->account->name }}</td>
                            <td class="text-right">{{ number_format($transaction->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        
        <div class="footer">
            <p>রিপোর্ট তৈরির তারিখ: {{ now()->format('d M, Y H:i') }}</p>
        </div>
    </div>
</body>
</html> 