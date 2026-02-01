@extends('layouts.app')

@section('title', 'রিপোর্ট')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">রিপোর্ট</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center">
                                    <h5 class="card-title">মাসিক রিপোর্ট</h5>
                                    <p class="card-text">মাসিক আয়-ব্যয়ের রিপোর্ট দেখুন</p>
                                    <a href="{{ route('reports.monthly') }}" class="btn btn-primary">মাসিক রিপোর্ট দেখুন</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <h5 class="card-title">বার্ষিক রিপোর্ট</h5>
                                    <p class="card-text">বাৎসরিক আয়-ব্যয়ের রিপোর্ট দেখুন</p>
                                    <a href="{{ route('reports.yearly') }}" class="btn btn-success">বার্ষিক রিপোর্ট দেখুন</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-info">
                                <div class="card-body text-center">
                                    <h5 class="card-title">কাস্টম রিপোর্ট</h5>
                                    <p class="card-text">নির্দিষ্ট সময়ের আয়-ব্যয়ের রিপোর্ট দেখুন</p>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#customReportModal">
                                        কাস্টম রিপোর্ট তৈরি করুন
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Report Modal -->
<div class="modal fade" id="customReportModal" tabindex="-1" aria-labelledby="customReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('reports.custom') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="customReportModalLabel">কাস্টম রিপোর্ট</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">শুরুর তারিখ</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">শেষের তারিখ</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                    <button type="submit" class="btn btn-primary">রিপোর্ট দেখুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 