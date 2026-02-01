@extends('layouts.app')

@section('title', 'হেল্প ডেস্ক')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">হেল্প ডেস্ক</h5>
                </div>
                <div class="card-body">
                    <h6>আমাদের সাথে যোগাযোগ করুন</h6>
                    <p>আপনার কোন প্রশ্ন বা সমস্যা থাকলে আমাদের সাথে যোগাযোগ করুন:</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> ইমেইল: support@amarkhata.com</li>
                        <li><i class="fas fa-phone me-2"></i> ফোন: +880 1234567890</li>
                        <li><i class="fas fa-clock me-2"></i> সময়: সকাল ৯টা - সন্ধ্যা ৬টা</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 