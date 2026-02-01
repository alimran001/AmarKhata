@extends('layouts.app')

@section('title', 'আমার খাতা - পার্সোনাল ফিনান্স ট্র্যাকার')

@section('meta')
<meta name="description" content="আমার খাতা - আপনার আয়, ব্যয়, সঞ্চয় এবং লোন একই জায়গায় ট্র্যাক করুন। আমার খাতার সাথে আপনার আর্থিক জীবন নিয়ন্ত্রণে রাখুন।">
<meta name="keywords" content="আমার খাতা, পার্সোনাল ফিনান্স, আয় ব্যয় হিসাব, লোন ম্যানেজমেন্ট, বাংলা অ্যাকাউন্টিং সফটওয়্যার">
<meta property="og:title" content="আমার খাতা - পার্সোনাল ফিনান্স ট্র্যাকার">
<meta property="og:description" content="আপনার আয়, ব্যয়, সঞ্চয় এবং লোন একই জায়গায় ট্র্যাক করুন। আমার খাতার সাথে আপনার আর্থিক জীবন নিয়ন্ত্রণে রাখুন।">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero-section bg-gradient-primary py-5">
    <div class="container">
        <div class="row align-items-center" style="min-height: 80vh;">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="display-4 fw-bold text-white mb-3">আমার খাতা</h1>
                <h2 class="h3 text-white-50 mb-4">{{ __('পার্সোনাল ফিনান্স ট্র্যাকার') }}</h2>
                <p class="lead text-white-50 mb-5">
                    {{ __('আপনার আয়, ব্যয়, সঞ্চয় এবং লোন একই জায়গায় ট্র্যাক করুন। আমার খাতার সাথে আপনার আর্থিক জীবন নিয়ন্ত্রণে রাখুন।') }}
                </p>
                <div class="d-grid gap-3 d-md-flex justify-content-md-start mb-4">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 shadow-sm fw-bold">{{ __('শুরু করুন') }}</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 py-3">{{ __('লগইন') }}</a>
                </div>
                
                <div class="d-flex align-items-center mt-4">
                    <div class="me-4">
                        <span class="d-block text-white-50"><i class="fas fa-check-circle text-white me-2"></i> {{ __('বিনামূল্যে ব্যবহার করুন') }}</span>
                    </div>
                    <div>
                        <span class="d-block text-white-50"><i class="fas fa-check-circle text-white me-2"></i> {{ __('কোন রেজিস্ট্রেশন ফি নেই') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex justify-content-center">
                <div class="position-relative">
                    <img src="{{ asset('images/dashboard-mockup.png') }}" class="img-fluid rounded-4 shadow-lg" alt="আমার খাতা ড্যাশবোর্ড" onerror="this.src='https://via.placeholder.com/600x400?text=আমার+খাতা'">
                    <div class="position-absolute top-0 start-100 translate-middle badge bg-success p-3 rounded-pill">
                        <span class="h6 mb-0">{{ __('নতুন') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 mb-3">{{ __('বৈশিষ্ট্য') }}</span>
            <h2 class="fw-bold mb-4">{{ __('আমার খাতা কেন ব্যবহার করবেন?') }}</h2>
            <p class="lead text-muted mb-0 mx-auto" style="max-width: 700px;">{{ __('আমাদের বৈশিষ্ট্যগুলি আপনার আর্থিক ব্যবস্থাপনা সহজ করে তোলে') }}</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow">
                <div class="card-body p-4">
                    <div class="feature-icon bg-primary-subtle p-3 rounded-3 d-inline-block mb-4">
                        <i class="fas fa-wallet text-primary fa-2x"></i>
                    </div>
                    <h3 class="h4 card-title">{{ __('একাধিক অ্যাকাউন্ট') }}</h3>
                    <p class="card-text text-muted">{{ __('নগদ, ব্যাংক অ্যাকাউন্ট, মোবাইল ব্যাংকিং সবকিছু একই জায়গায় পরিচালনা করুন') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow">
                <div class="card-body p-4">
                    <div class="feature-icon bg-primary-subtle p-3 rounded-3 d-inline-block mb-4">
                        <i class="fas fa-exchange-alt text-primary fa-2x"></i>
                    </div>
                    <h3 class="h4 card-title">{{ __('আয় ও ব্যয় ট্র্যাকিং') }}</h3>
                    <p class="card-text text-muted">{{ __('কাস্টমাইজযোগ্য বিভাগ সহ আপনার সমস্ত লেনদেন লগ করুন') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow">
                <div class="card-body p-4">
                    <div class="feature-icon bg-primary-subtle p-3 rounded-3 d-inline-block mb-4">
                        <i class="fas fa-hand-holding-usd text-primary fa-2x"></i>
                    </div>
                    <h3 class="h4 card-title">{{ __('লোন ম্যানেজমেন্ট') }}</h3>
                    <p class="card-text text-muted">{{ __('আপনি যে অর্থ ধার নিয়েছেন বা ধার দিয়েছেন তার হিসাব রাখুন') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Benefits Section -->
<div class="bg-light py-5">
    <div class="container py-3">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 mb-3">{{ __('সুবিধা') }}</span>
                <h2 class="fw-bold mb-4">{{ __('আমার খাতা আপনাকে কীভাবে সাহায্য করে') }}</h2>
                <p class="lead text-muted mb-0 mx-auto" style="max-width: 700px;">{{ __('আপনার আর্থিক লক্ষ্য অর্জনে আমরা সাহায্য করি') }}</p>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('images/financial-report.png') }}" class="img-fluid rounded-4 shadow" alt="আর্থিক রিপোর্ট" onerror="this.src='https://via.placeholder.com/600x400?text=আর্থিক+রিপোর্ট'">
            </div>
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-chart-pie text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="h5 mb-2">{{ __('বিস্তারিত রিপোর্ট') }}</h4>
                                <p class="text-muted mb-0">{{ __('ভিজ্যুয়াল রিপোর্ট এবং চার্ট দিয়ে অন্তর্দৃষ্টি পান') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-globe text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="h5 mb-2">{{ __('মাল্টি-ল্যাঙ্গুয়েজ সাপোর্ট') }}</h4>
                                <p class="text-muted mb-0">{{ __('বাংলা, ইংরেজি, বা হিন্দিতে অ্যাপ ব্যবহার করুন') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-mobile-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="h5 mb-2">{{ __('মোবাইল ফ্রেন্ডলি') }}</h4>
                                <p class="text-muted mb-0">{{ __('যেকোনো ডিভাইসে আপনার অর্থ পরিচালনা করুন') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-lock text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="h5 mb-2">{{ __('নিরাপদ') }}</h4>
                                <p class="text-muted mb-0">{{ __('আপনার আর্থিক তথ্য এনক্রিপ্টেড এবং সুরক্ষিত') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 mb-3">{{ __('টেস্টিমোনিয়াল') }}</span>
            <h2 class="fw-bold mb-4">{{ __('ব্যবহারকারীদের মতামত') }}</h2>
            <p class="lead text-muted mb-0 mx-auto" style="max-width: 700px;">{{ __('আমাদের ব্যবহারকারীরা আমার খাতা সম্পর্কে কী বলেন') }}</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="card-text mb-4">"আমার খাতা আমার আর্থিক জীবনকে সম্পূর্ণরূপে পরিবর্তন করেছে। এখন আমি আমার আয় ও ব্যয়ের হিসাব সহজেই রাখতে পারি।"</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <span class="text-white fw-bold">কে</span>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">করিম আহমেদ</h5>
                            <small class="text-muted">ব্যবসায়ী, ঢাকা</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="card-text mb-4">"লোন ম্যানেজমেন্ট ফিচারটি আমার জন্য খুবই উপকারী। আমি কাকে কত টাকা দিয়েছি বা কার কাছ থেকে কত নিয়েছি সবই এখানে রেকর্ড করতে পারি।"</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <span class="text-white fw-bold">স</span>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">সাবরিনা খান</h5>
                            <small class="text-muted">শিক্ষক, চট্টগ্রাম</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star-half-alt text-warning"></i>
                    </div>
                    <p class="card-text mb-4">"রিপোর্টিং সিস্টেম অসাধারণ। মাসিক, সাপ্তাহিক এবং বার্ষিক রিপোর্ট দেখে আমি আমার খরচ কোথায় বেশি হচ্ছে তা বুঝতে পারি।"</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <span class="text-white fw-bold">র</span>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">রাকিব হাসান</h5>
                            <small class="text-muted">সফটওয়্যার ইঞ্জিনিয়ার, খুলনা</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-primary py-5">
    <div class="container py-4">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="fw-bold text-white mb-4">{{ __('আজই আমার খাতা ব্যবহার শুরু করুন') }}</h2>
                <p class="lead text-white-50 mb-4">{{ __('আপনার আর্থিক জীবন নিয়ন্ত্রণে রাখুন। কোন চার্জ ছাড়াই শুরু করুন।') }}</p>
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 shadow fw-bold">{{ __('বিনামূল্যে রেজিস্টার করুন') }}</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 py-3">{{ __('লগইন করুন') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add custom styles -->
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #e04b46 100%);
    }
    
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        transition: all 0.3s ease;
    }
    
    .feature-icon {
        transition: all 0.3s ease;
    }
    
    .card:hover .feature-icon {
        transform: scale(1.1);
    }
    
    .bg-primary-subtle {
        background-color: rgba(254, 91, 86, 0.1);
    }
    
    .rounded-4 {
        border-radius: 1rem;
    }
</style>
@endsection 