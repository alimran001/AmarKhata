<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AJAX টেস্ট</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>ক্যাটেগরি AJAX টেস্ট</h1>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>ক্যাটেগরি লোড করুন</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="type" class="form-label">টাইপ নির্বাচন করুন</label>
                            <select class="form-select" id="type">
                                <option value="income">আয়</option>
                                <option value="expense">ব্যয়</option>
                            </select>
                        </div>
                        
                        <button id="loadBtn" class="btn btn-primary">লোড করুন</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>ফলাফল</h5>
                    </div>
                    <div class="card-body">
                        <pre id="result" style="min-height: 200px; background-color: #f8f9fa; padding: 10px; border-radius: 5px;">ফলাফল এখানে দেখা যাবে...</pre>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>রিকোয়েস্ট লগ</h5>
                    </div>
                    <div class="card-body">
                        <pre id="requestLog" style="min-height: 100px; background-color: #f8f9fa; padding: 10px; border-radius: 5px;">রিকোয়েস্ট লগ এখানে দেখা যাবে...</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadBtn = document.getElementById('loadBtn');
            const typeSelect = document.getElementById('type');
            const resultDiv = document.getElementById('result');
            const requestLogDiv = document.getElementById('requestLog');
            
            loadBtn.addEventListener('click', function() {
                const type = typeSelect.value;
                resultDiv.textContent = 'লোড হচ্ছে...';
                
                // লগ রিকোয়েস্ট
                const logEntry = `${new Date().toLocaleTimeString()}: /categories/by-type?type=${type} এ রিকোয়েস্ট পাঠানো হচ্ছে...`;
                requestLogDiv.textContent = logEntry + '\n' + requestLogDiv.textContent;
                
                // AJAX কল
                fetch(`/categories/by-type?type=${type}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    // লগ রেসপন্স স্ট্যাটাস
                    const statusLog = `${new Date().toLocaleTimeString()}: রেসপন্স স্ট্যাটাস: ${response.status} ${response.statusText}`;
                    requestLogDiv.textContent = statusLog + '\n' + requestLogDiv.textContent;
                    
                    if (!response.ok) {
                        throw new Error(`HTTP এরর ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // লগ রেসপন্স ডাটা
                    const dataLog = `${new Date().toLocaleTimeString()}: ডাটা প্রাপ্ত: ${data.length} টি আইটেম`;
                    requestLogDiv.textContent = dataLog + '\n' + requestLogDiv.textContent;
                    
                    resultDiv.textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    // লগ এরর
                    const errorLog = `${new Date().toLocaleTimeString()}: এরর: ${error.message}`;
                    requestLogDiv.textContent = errorLog + '\n' + requestLogDiv.textContent;
                    
                    resultDiv.textContent = `এরর: ${error.message}`;
                });
            });
        });
    </script>
</body>
</html> 