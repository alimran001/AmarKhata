@extends('layouts.app')

@section('title', 'সেটিংস')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-cog text-primary me-2"></i>সেটিংস
                    </h5>
                </div>
                <div class="card-body p-0">
                    <!-- প্রোফাইল সেটিংস -->
                    <div class="settings-section p-3 border-bottom">
                        <h6 class="text-muted mb-3">প্রোফাইল সেটিংস</h6>
                        <a href="{{ route('profile.edit') }}" class="settings-item d-flex align-items-center p-2 rounded-3 text-decoration-none text-dark hover-bg-light">
                            <div class="settings-icon me-3">
                                <i class="fas fa-user-circle fa-lg text-primary"></i>
                            </div>
                            <div class="settings-content flex-grow-1">
                                <h6 class="mb-1">প্রোফাইল সম্পাদনা</h6>
                                <small class="text-muted">আপনার ব্যক্তিগত তথ্য আপডেট করুন</small>
                            </div>
                            <div class="settings-arrow">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>
                    </div>

                    <!-- অ্যাকাউন্ট সেটিংস -->
                    <div class="settings-section p-3 border-bottom">
                        <h6 class="text-muted mb-3">অ্যাকাউন্ট সেটিংস</h6>
                        <a href="{{ route('password.update') }}" class="settings-item d-flex align-items-center p-2 rounded-3 text-decoration-none text-dark hover-bg-light">
                            <div class="settings-icon me-3">
                                <i class="fas fa-lock fa-lg text-primary"></i>
                            </div>
                            <div class="settings-content flex-grow-1">
                                <h6 class="mb-1">পাসওয়ার্ড পরিবর্তন</h6>
                                <small class="text-muted">আপনার পাসওয়ার্ড আপডেট করুন</small>
                            </div>
                            <div class="settings-arrow">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>
                    </div>

                    <!-- নোটিফিকেশন সেটিংস -->
                    <div class="settings-section p-3 border-bottom">
                        <h6 class="text-muted mb-3">নোটিফিকেশন সেটিংস</h6>
                        <div class="settings-item d-flex align-items-center p-2 rounded-3">
                            <div class="settings-icon me-3">
                                <i class="fas fa-bell fa-lg text-primary"></i>
                            </div>
                            <div class="settings-content flex-grow-1">
                                <h6 class="mb-1">পুশ নোটিফিকেশন</h6>
                                <small class="text-muted">নতুন লেনদেনের নোটিফিকেশন পান</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="pushNotification" checked>
                            </div>
                        </div>
                        <div class="settings-item d-flex align-items-center p-2 rounded-3 mt-2">
                            <div class="settings-icon me-3">
                                <i class="fas fa-envelope fa-lg text-primary"></i>
                            </div>
                            <div class="settings-content flex-grow-1">
                                <h6 class="mb-1">ইমেইল নোটিফিকেশন</h6>
                                <small class="text-muted">ইমেইলে নোটিফিকেশন পান</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotification">
                            </div>
                        </div>
                    </div>

                    <!-- অ্যাপ সেটিংস -->
                    <div class="settings-section p-3 border-bottom">
                        <h6 class="text-muted mb-3">অ্যাপ সেটিংস</h6>
                        
                        <!-- ডার্ক মোড -->
                        <div class="settings-item d-flex align-items-center p-2 rounded-3">
                            <div class="settings-icon me-3">
                                <i class="fas fa-moon fa-lg text-primary"></i>
                            </div>
                            <div class="settings-content flex-grow-1">
                                <h6 class="mb-1">ডার্ক মোড</h6>
                                <small class="text-muted">ডার্ক থিম ব্যবহার করুন</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="darkMode">
                            </div>
                        </div>
                    </div>

                    <!-- ডেটা ম্যানেজমেন্ট -->
                    <div class="settings-section p-3">
                        <h6 class="text-muted mb-3">ডেটা ম্যানেজমেন্ট</h6>
                        <a href="#" class="settings-item d-flex align-items-center p-2 rounded-3 text-decoration-none text-dark hover-bg-light">
                            <div class="settings-icon me-3">
                                <i class="fas fa-download fa-lg text-primary"></i>
                            </div>
                            <div class="settings-content flex-grow-1">
                                <h6 class="mb-1">ডেটা ডাউনলোড</h6>
                                <small class="text-muted">আপনার সব ডেটা ডাউনলোড করুন</small>
                            </div>
                            <div class="settings-arrow">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>
                        <a href="#" class="settings-item d-flex align-items-center p-2 rounded-3 text-decoration-none text-dark hover-bg-light mt-2" data-bs-toggle="modal" data-bs-target="#deleteDataModal">
                            <div class="settings-icon me-3">
                                <i class="fas fa-trash-alt fa-lg text-danger"></i>
                            </div>
                            <div class="settings-content flex-grow-1">
                                <h6 class="mb-1">ডেটা মুছে ফেলুন</h6>
                                <small class="text-muted">সব ডেটা স্থায়ীভাবে মুছে ফেলুন</small>
                            </div>
                            <div class="settings-arrow">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ডেটা ডিলিট মোডাল -->
<div class="modal fade" id="deleteDataModal" tabindex="-1" aria-labelledby="deleteDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDataModalLabel">ডেটা মুছে ফেলার নিশ্চিতকরণ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>সতর্কতা:</strong> এই পদক্ষেপটি অপরিবর্তনীয়। সমস্ত ডেটা স্থায়ীভাবে মুছে ফেলা হবে।
                </div>
                <p>আপনি কি নিশ্চিত যে আপনি আপনার সমস্ত হিসাব ডেটা মুছে ফেলতে চান?</p>
                <form id="deleteDataForm" action="{{ route('account.delete') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">নিশ্চিত করতে আপনার পাসওয়ার্ড লিখুন</label>
                        <input type="password" class="form-control" id="confirmPassword" name="current_password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteDataForm').submit()">ডেটা মুছে ফেলুন</button>
            </div>
        </div>
    </div>
</div>

<style>
.settings-item {
    transition: all 0.2s ease;
}

.settings-item:hover {
    background-color: #f8f9fa;
}

.settings-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background-color: rgba(254, 91, 86, 0.1);
}

.form-check-input:checked {
    background-color: #FE5B56;
    border-color: #FE5B56;
}

.form-check-input:focus {
    border-color: #FE5B56;
    box-shadow: 0 0 0 0.25rem rgba(254, 91, 86, 0.25);
}

.settings-section:last-child {
    border-bottom: none !important;
}

/* ডার্ক মোড স্টাইল */
body.dark-mode {
    background-color: #1a1a1a;
    color: #ffffff;
}

body.dark-mode .card {
    background-color: #2d2d2d;
    border-color: #3d3d3d;
}

body.dark-mode .card-header {
    background-color: #2d2d2d;
    border-color: #3d3d3d;
}

body.dark-mode .settings-item {
    color: #ffffff;
}

body.dark-mode .settings-item:hover {
    background-color: #3d3d3d;
}

body.dark-mode .text-muted {
    color: #a0a0a0 !important;
}

body.dark-mode .form-control {
    background-color: #3d3d3d;
    border-color: #4d4d4d;
    color: #ffffff;
}

body.dark-mode .form-control:focus {
    background-color: #3d3d3d;
    color: #ffffff;
}

body.dark-mode .btn-outline-secondary {
    color: #ffffff;
    border-color: #ffffff;
}

body.dark-mode .btn-outline-secondary:hover {
    background-color: #ffffff;
    color: #1a1a1a;
}

body.dark-mode .settings-icon {
    background-color: rgba(254, 91, 86, 0.2);
}

body.dark-mode .form-check-input {
    background-color: #3d3d3d;
    border-color: #4d4d4d;
}

body.dark-mode .form-check-input:checked {
    background-color: #FE5B56;
    border-color: #FE5B56;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ডার্ক মোড টগল
    const darkModeToggle = document.getElementById('darkMode');
    
    // সেভ করা ডার্ক মোড স্টেট লোড
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
        darkModeToggle.checked = true;
    }
    
    darkModeToggle.addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'true');
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'false');
        }
    });

    // নোটিফিকেশন টগল
    const pushNotification = document.getElementById('pushNotification');
    const emailNotification = document.getElementById('emailNotification');
    
    pushNotification.addEventListener('change', function() {
        // পুশ নোটিফিকেশন সেটিংস সেভ করার লজিক যোগ করুন
    });
    
    emailNotification.addEventListener('change', function() {
        // ইমেইল নোটিফিকেশন সেটিংস সেভ করার লজিক যোগ করুন
    });
});
</script>
@endsection 