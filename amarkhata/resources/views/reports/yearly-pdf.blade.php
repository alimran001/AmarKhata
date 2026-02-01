<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>বার্ষিক রিপোর্ট</title>
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
        <h1>বার্ষিক আয়-ব্যয় রিপোর্ট</h1>
        <h3>{{ $year }}</h3>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>মোট আয়:</strong> ৳ {{ number_format($totalIncome, 2) }}
        </div>
        <div class="summary-item">
            <strong>মোট ব্যয়:</strong> ৳ {{ number_format($totalExpense, 2) }}
        </div>
        <div class="summary-item">
            <strong>ব্যালেন্স:</strong> ৳ {{ number_format($totalIncome - $totalExpense, 2) }}
        </div>
    </div>

    <h4>মাস অনুযায়ী আয়-ব্যয়</h4>
    <table class="table">
        <thead>
            <tr>
                <th>মাস</th>
                <th class="text-right">আয়</th>
                <th class="text-right">ব্যয়</th>
                <th class="text-right">ব্যালেন্স</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyData as $data)
            <tr>
                <td>{{ $data['month'] }}</td>
                <td class="text-right">৳ {{ number_format($data['income'], 2) }}</td>
                <td class="text-right">৳ {{ number_format($data['expense'], 2) }}</td>
                <td class="text-right">৳ {{ number_format($data['income'] - $data['expense'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center" style="margin-top: 30px;">
        <p>রিপোর্ট তৈরি: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html> 