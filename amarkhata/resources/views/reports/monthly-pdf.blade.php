<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>মাসিক রিপোর্ট</title>
    <style>
        /* ফন্ট স্টাইল */
        @font-face {
            font-family: 'Nikosh';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/Nikosh.ttf') }}) format('truetype');
        }
        
        /* সকল টেক্সটের জন্য */
        body, table, td, th, div, p, h1, h2, h3, h4, h5, h6 {
            font-family: 'Nikosh' !important;
        }
        
        body {
            font-size: 13px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        
        /* টেবিল স্টাইল */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .fw-bold { font-weight: bold; }
        
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            background-color: #fff;
        }
        
        .card-header {
            padding: 10px 15px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        
        .card-body {
            padding: 15px;
        }
        
        .row {
            display: flex;
            margin-right: -15px;
            margin-left: -15px;
        }
        
        .col-6 {
            width: 50%;
            padding-right: 15px;
            padding-left: 15px;
        }
    </style>
</head>
<body>
    <div class="text-center mb-3">
        <h2 style="font-size: 24px; margin: 0;">মাসিক রিপোর্ট</h2>
        <h3 style="font-size: 18px; margin: 5px 0 0 0;">{{ $monthName }}</h3>
    </div>
    
    <div class="mb-3">
        <table>
            <tr>
                <th>মোট আয়</th>
                <th>মোট ব্যয়</th>
                <th>ব্যালেন্স</th>
            </tr>
            <tr>
                <td class="text-right">{{ number_format($totalIncome, 2) }} ৳</td>
                <td class="text-right">{{ number_format($totalExpense, 2) }} ৳</td>
                <td class="text-right">{{ number_format($balance, 2) }} ৳</td>
            </tr>
        </table>
    </div>
    
    <!-- লোন স্ট্যাটাস -->
    <div class="mb-3">
        <h4 class="mb-2">লোন স্ট্যাটাস</h4>
        <table>
            <tr>
                <th colspan="2">আমি দিয়েছি</th>
                <th colspan="2">আমি নিয়েছি</th>
            </tr>
            <tr>
                <td>মোট পরিমাণ</td>
                <td class="text-right">{{ number_format($givenLoans['total'], 2) }} ৳</td>
                <td>মোট পরিমাণ</td>
                <td class="text-right">{{ number_format($takenLoans['total'], 2) }} ৳</td>
            </tr>
            <tr>
                <td>পরিশোধিত</td>
                <td class="text-right">{{ number_format($givenLoans['paid'], 2) }} ৳</td>
                <td>পরিশোধিত</td>
                <td class="text-right">{{ number_format($takenLoans['paid'], 2) }} ৳</td>
            </tr>
            <tr>
                <td>বাকি আছে</td>
                <td class="text-right">{{ number_format($givenLoans['remaining'], 2) }} ৳</td>
                <td>বাকি আছে</td>
                <td class="text-right">{{ number_format($takenLoans['remaining'], 2) }} ৳</td>
            </tr>
        </table>
    </div>
    
    @if(count($categoryExpense) > 0)
    <div class="mb-3">
        <h4 class="mb-2">ব্যয়ের বিভাগ</h4>
        <table>
            <tr>
                <th>বিভাগ</th>
                <th class="text-right">পরিমাণ</th>
                <th class="text-right">শতাংশ</th>
            </tr>
            @foreach($categoryExpense as $expense)
            <tr>
                <td>{{ $expense->name }}</td>
                <td class="text-right">{{ number_format($expense->total, 2) }} ৳</td>
                <td class="text-right">{{ number_format(($expense->total / $totalExpense) * 100, 1) }}%</td>
            </tr>
            @endforeach
            <tr>
                <th>মোট</th>
                <th class="text-right">{{ number_format($totalExpense, 2) }} ৳</th>
                <th class="text-right">100%</th>
            </tr>
        </table>
    </div>
    @endif
    
    @if(count($categoryIncome) > 0)
    <div class="mb-3">
        <h4 class="mb-2">আয়ের বিভাগ</h4>
        <table>
            <tr>
                <th>বিভাগ</th>
                <th class="text-right">পরিমাণ</th>
                <th class="text-right">শতাংশ</th>
            </tr>
            @foreach($categoryIncome as $income)
            <tr>
                <td>{{ $income->name }}</td>
                <td class="text-right">{{ number_format($income->total, 2) }} ৳</td>
                <td class="text-right">{{ number_format(($income->total / $totalIncome) * 100, 1) }}%</td>
            </tr>
            @endforeach
            <tr>
                <th>মোট</th>
                <th class="text-right">{{ number_format($totalIncome, 2) }} ৳</th>
                <th class="text-right">100%</th>
            </tr>
        </table>
    </div>
    @endif
    
    <div class="mb-3">
        <h4 class="mb-2">হিসাব বিবরণ</h4>
        <table>
            <tr>
                <th>হিসাবের নাম</th>
                <th>টাইপ</th>
                <th class="text-right">ব্যালেন্স</th>
            </tr>
            @foreach($accountBalances as $account)
            <tr>
                <td>{{ $account->name }}</td>
                <td>{{ $account->type }}</td>
                <td class="text-right">{{ number_format($account->month_end_balance, 2) }} ৳</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="text-center" style="margin-top: 30px;">
        <p>রিপোর্ট তৈরি: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html> 