<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>কাস্টম রিপোর্ট</title>
    <style>
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('{{ storage_path('fonts/SolaimanLipi.ttf') }}') format('truetype');
        }
        body {
            font-family: 'SolaimanLipi', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .summary {
            margin-bottom: 20px;
        }
        .summary-item {
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
            background-color: #f5f5f5;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>কাস্টম আয়-ব্যয় রিপোর্ট</h1>
        <h3>{{ $startDate }} থেকে {{ $endDate }}</h3>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>মোট আয়:</strong> ৳ {{ number_format($income, 2) }}
        </div>
        <div class="summary-item">
            <strong>মোট ব্যয়:</strong> ৳ {{ number_format($expense, 2) }}
        </div>
        <div class="summary-item">
            <strong>ব্যালেন্স:</strong> ৳ {{ number_format($income - $expense, 2) }}
        </div>
    </div>

    <h4>লেনদেনের তালিকা</h4>
    <table class="table">
        <thead>
            <tr>
                <th>তারিখ</th>
                <th>ধরন</th>
                <th>বিবরণ</th>
                <th>ক্যাটেগরি</th>
                <th class="text-right">পরিমাণ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->date->format('d/m/Y') }}</td>
                <td>{{ $transaction->type == 'income' ? 'আয়' : 'ব্যয়' }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->category->name }}</td>
                <td class="text-right">৳ {{ number_format($transaction->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center" style="margin-top: 30px;">
        <p>রিপোর্ট তৈরি: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html> 