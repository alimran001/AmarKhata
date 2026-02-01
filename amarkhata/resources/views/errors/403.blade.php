<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>৪০৩ - অ্যাক্সেস নিষিদ্ধ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            background-color: white;
            max-width: 500px;
        }
        .error-code {
            font-size: 5rem;
            font-weight: bold;
            color: #dc3545;
        }
        .error-message {
            font-size: 1.5rem;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">৪০৩</div>
        <div class="error-message">অ্যাক্সেস নিষিদ্ধ!</div>
        <p class="mb-4">দুঃখিত, আপনি এই পেজ দেখার অনুমতি পাননি।</p>
        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">ড্যাশবোর্ডে ফিরে যান</a>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary ms-2">হোমপেজে যান</a>
        </div>
    </div>
</body>
</html> 