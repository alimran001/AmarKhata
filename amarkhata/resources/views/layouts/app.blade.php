<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AmarKhata') }} - @yield('title')</title>
    
    @yield('meta')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FE5B56;
            --secondary-color: #E4BE06;
            --white-color: #FFFFFF;
            --light-bg: #f8f8f8;
            --text-color: #333333;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }
        
        /* Custom Bootstrap Override */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: #e04b46 !important;
            border-color: #e04b46 !important;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: #212529;
        }
        
        .btn-secondary:hover, .btn-secondary:focus, .btn-secondary:active {
            background-color: #c5a305 !important;
            border-color: #c5a305 !important;
            color: #212529 !important;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(228, 190, 6, 0.25);
        }
        
        .form-control, .form-select {
            border-color: var(--secondary-color);
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .text-secondary {
            color: var(--secondary-color) !important;
        }
        
        .border-primary {
            border-color: var(--primary-color) !important;
        }
        
        .border-secondary {
            border-color: var(--secondary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .bg-secondary {
            background-color: var(--secondary-color) !important;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--white-color);
            padding-bottom: 60px; /* বটম নেভিগেশন বারের জন্য কম স্পেস */
            font-size: 0.95rem; /* সব টেক্সট আকার ছোট করা */
        }
        
        /* মোবাইল ফ্রেন্ডলি কন্টেইনার */
        .container {
            padding-left: 10px;
            padding-right: 10px;
            max-width: 100%;
        }
        
        /* কার্ড ডিজাইন ছোট ও কম্প্যাক্ট করা */
        .card {
            border-radius: 0.4rem;
            box-shadow: 0 0.1rem 0.2rem var(--shadow-color);
            border: none;
            background-color: var(--white-color);
            margin-bottom: 10px;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        .card-header {
            padding: 0.5rem 0.75rem;
            background-color: var(--white-color);
        }
        
        /* টাইটেল ও হেডিং ছোট করা */
        h1, .h1 { font-size: 1.5rem; }
        h2, .h2 { font-size: 1.3rem; }
        h3, .h3 { font-size: 1.2rem; }
        h4, .h4 { font-size: 1.1rem; }
        h5, .h5 { font-size: 1rem; }
        h6, .h6 { font-size: 0.9rem; }
        
        /* নেভবার কম্প্যাক্ট করা */
        .navbar {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        /* বটম নেভিগেশন বার স্টাইল */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: var(--white-color);
            box-shadow: 0 -2px 5px var(--shadow-color);
            z-index: 1000;
            padding: 5px 0;
            height: 60px;
        }
        
        .bottom-nav .nav-item {
            text-align: center;
            flex: 1;
        }
        
        .bottom-nav .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 5px 0;
            font-size: 0.7rem;
            position: relative;
            color: #888;
            transition: color 0.2s;
        }
        
        .bottom-nav .nav-link i {
            font-size: 1.1rem;
            margin-bottom: 2px;
        }
        
        .bottom-nav .nav-link.active {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .bottom-nav .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }

        /* বটম নেভিগেশন ড্রপডাউন স্টাইল */
        .bottom-nav .dropdown-menu {
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            border: none;
            padding: 0;
            min-width: 250px;
        }

        .bottom-nav .dropdown-item {
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .bottom-nav .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .bottom-nav .dropdown-divider {
            margin: 0;
        }
        
        /* সাইড মেনু টগল স্টাইল */
        .side-menu {
            position: fixed;
            top: 0;
            right: -280px;
            width: 80%; /* মোবাইলে বড় এরিয়া কভার করবে */
            max-width: 280px;
            height: 100vh;
            background-color: var(--white-color);
            z-index: 2000;
            box-shadow: -2px 0 10px var(--shadow-color);
            transition: all 0.3s ease;
            padding-top: 56px;
            overflow-y: auto;
        }
        
        .side-menu.show {
            right: 0;
        }
        
        .side-menu-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1999;
            display: none;
        }
        
        .side-menu-backdrop.show {
            display: block;
        }
        
        /* মেনু আইকন স্টাইল */
        .menu-icon {
            position: fixed;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2001;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            /* আইকন অদৃশ্য করার জন্য */
            background-image: none !important;
        }
        
        .menu-icon i {
            font-size: 1.2rem;
        }
        
        /* ফর্ম এলিমেন্ট কম্প্যাক্ট করা */
        .form-control, .form-select {
            padding: 0.375rem 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-label {
            margin-bottom: 0.25rem;
            font-size: 0.85rem;
        }
        
        .mb-3 {
            margin-bottom: 0.75rem !important;
        }
        
        /* টোটাল ব্যালেন্স কার্ড */
        .total-balance-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white-color);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 3px 10px rgba(254, 91, 86, 0.2);
        }
        
        .balance-icon {
            width: 45px;
            height: 45px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }
        
        .transaction-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .btn-transaction {
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.15);
            border: none;
            border-radius: 8px;
            color: white;
            padding: 8px 12px;
            flex: 1;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }
        
        .btn-transaction:hover {
            background-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }
        
        .btn-transaction:active {
            transform: translateY(0);
        }
        
        .btn-transaction .btn-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 0.7rem;
        }
        
        .income-btn .btn-icon {
            background-color: rgba(40, 167, 69, 0.3);
        }
        
        .expense-btn .btn-icon {
            background-color: rgba(220, 53, 69, 0.3);
        }
        
        @media (max-width: 576px) {
            .total-balance-card {
                padding: 12px;
                margin-bottom: 12px;
            }
            
            .balance-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
            
            .transaction-buttons {
                margin-top: 12px;
            }
            
            .btn-transaction {
                padding: 6px 10px;
                font-size: 0.75rem;
            }
            
            .btn-transaction .btn-icon {
                width: 20px;
                height: 20px;
                margin-right: 6px;
                font-size: 0.65rem;
            }
        }
        
        /* ডার্ক মোড অ্যাডজাস্টমেন্ট */
        body.dark-mode .total-balance-card {
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.3);
        }
        
        body.dark-mode .btn-transaction {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        body.dark-mode .btn-transaction:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        /* ফ্লোটিং অ্যাকশন বাটন */
        .floating-action-btn {
            position: fixed;
            right: 15px;
            bottom: 70px; /* বটম নেভিগেশন বারের উপরে */
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary-color);
            box-shadow: 0 3px 8px var(--shadow-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white-color);
            font-size: 20px;
            cursor: pointer;
            z-index: 999;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        /* পপআপ মেনু স্টাইল */
        .popup-menu {
            position: fixed;
            right: 15px;
            bottom: 130px;
            background-color: var(--white-color);
            border-radius: 8px;
            box-shadow: 0 2px 10px var(--shadow-color);
            width: auto;
            min-width: 180px;
            display: none;
            flex-direction: column;
            z-index: 998;
            overflow: hidden;
        }

        .popup-menu.show {
            display: flex;
        }

        .popup-menu .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-color);
            text-decoration: none;
            transition: background-color 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .popup-menu .menu-item:hover {
            background-color: var(--light-bg);
        }

        .popup-menu .menu-item i {
            margin-right: 10px;
            font-size: 16px;
        }
        
        .popup-menu .menu-item .income-text {
            color: #28a745;
        }
        
        .popup-menu .menu-item .expense-text {
            color: #dc3545;
        }
        
        /* Row and column spacing */
        .row {
            margin-left: -8px;
            margin-right: -8px;
        }
        
        .col, .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, 
        .col-sm, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, 
        .col-md, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, 
        .col-lg, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, 
        .col-xl, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12 {
            padding-left: 8px;
            padding-right: 8px;
        }
        
        /* Button styles */
        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.85rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        /* Reduce margins and paddings */
        .mt-3 { margin-top: 0.75rem !important; }
        .mt-4 { margin-top: 1rem !important; }
        .mb-4 { margin-bottom: 1rem !important; }
        .my-3 { margin-top: 0.75rem !important; margin-bottom: 0.75rem !important; }
        .p-3 { padding: 0.75rem !important; }
        .py-3 { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
        
        /* List groups for accounts */
        .list-group-item {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }
        
        /* Responsive tables */
        .table {
            font-size: 0.85rem;
        }
        
        .table th, .table td {
            padding: 0.5rem;
        }
        
        /* Make charts responsive */
        .chart-container {
            position: relative;
            height: 30vh; /* Adjust based on screen size */
            max-height: 250px;
        }
        
        @media (max-width: 576px) {
            /* Extreme small devices */
            body {
                font-size: 0.9rem;
            }
            
            h1, .h1 { font-size: 1.4rem; }
            h2, .h2 { font-size: 1.25rem; }
            h3, .h3 { font-size: 1.15rem; }
            
            .container {
                padding-left: 8px;
                padding-right: 8px;
            }
            
            .card-body {
                padding: 0.6rem;
            }
            
            .floating-action-btn {
                width: 44px;
                height: 44px;
                font-size: 18px;
                right: 12px;
                bottom: 65px;
            }
        }

        /* ডার্ক মোড স্টাইল */
        body.dark-mode {
            background-color: #1a1a1a;
            color: #ffffff !important;
        }

        body.dark-mode * {
            color: #ffffff;
        }

        body.dark-mode .text-dark,
        body.dark-mode .text-body,
        body.dark-mode p,
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode .card-title,
        body.dark-mode .card-text,
        body.dark-mode label,
        body.dark-mode .form-label {
            color: #ffffff !important;
        }

        body.dark-mode .text-muted {
            color: #a0a0a0 !important;
        }

        body.dark-mode .nav-link,
        body.dark-mode .btn-link {
            color: #FE5B56;
        }

        body.dark-mode .nav-link:hover,
        body.dark-mode .btn-link:hover {
            color: #e04b46;
        }

        body.dark-mode .dropdown-menu {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode .dropdown-item {
            color: #ffffff !important;
        }

        body.dark-mode .dropdown-item:hover {
            background-color: #3d3d3d;
            color: #ffffff !important;
        }

        body.dark-mode .modal-title,
        body.dark-mode .modal-body,
        body.dark-mode .modal-footer {
            color: #ffffff;
        }

        body.dark-mode .table {
            color: #ffffff !important;
        }

        body.dark-mode .form-control::placeholder {
            color: #a0a0a0;
        }

        body.dark-mode .btn-primary {
            color: #ffffff !important;
        }

        body.dark-mode .btn-secondary {
            color: #ffffff !important;
        }

        body.dark-mode .btn-light {
            color: #ffffff !important;
        }

        body.dark-mode .alert {
            color: #ffffff !important;
        }

        body.dark-mode .navbar {
            background-color: #2d2d2d !important;
            border-color: #3d3d3d;
        }

        body.dark-mode .navbar-brand {
            color: #FE5B56 !important;
        }

        body.dark-mode .card {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode .card-header {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode .bottom-nav {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode .bottom-nav .nav-link {
            color: #aaa;
        }

        body.dark-mode .bottom-nav .nav-link.active {
            color: var(--primary-color);
        }

        body.dark-mode .side-menu {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode .side-menu .nav-link:hover {
            background-color: #3d3d3d;
        }

        body.dark-mode .modal-content {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode .modal-header {
            border-color: #3d3d3d;
        }

        body.dark-mode .modal-footer {
            border-color: #3d3d3d;
        }

        body.dark-mode .form-control {
            background-color: #3d3d3d;
            border-color: #4d4d4d;
        }

        body.dark-mode .form-control:focus {
            background-color: #3d3d3d;
        }

        body.dark-mode .btn-outline-secondary {
            border-color: #ffffff;
        }

        body.dark-mode .btn-outline-secondary:hover {
            background-color: #ffffff;
            color: #1a1a1a !important;
        }

        body.dark-mode .total-balance-card {
            background: linear-gradient(135deg, #2d2d2d, #3d3d3d);
        }

        body.dark-mode .popup-menu {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode .popup-menu .menu-item:hover {
            background-color: #3d3d3d;
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

        body.dark-mode .btn-light {
            background-color: #3d3d3d;
            border-color: #4d4d4d;
        }

        body.dark-mode .btn-light:hover {
            background-color: #4d4d4d;
            border-color: #5d5d5d;
        }

        body.dark-mode .alert {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode .alert-success {
            background-color: #1e3a1e;
            border-color: #2d4d2d;
        }

        body.dark-mode .alert-danger {
            background-color: #3a1e1e;
            border-color: #4d2d2d;
        }

        body.dark-mode .table td,
        body.dark-mode .table th {
            border-color: #3d3d3d;
        }

        body.dark-mode .pagination .page-link {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode .pagination .page-item.active .page-link {
            background-color: #FE5B56;
            border-color: #FE5B56;
        }

        body.dark-mode .bg-white,
        body.dark-mode .navbar-light,
        body.dark-mode .navbar-light.bg-white,
        body.dark-mode [class*="bg-white"] {
            background-color: #2d2d2d !important;
        }

        body.dark-mode .list-group-item {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        body.dark-mode div[class*="bg-light"],
        body.dark-mode section[class*="bg-light"],
        body.dark-mode article[class*="bg-light"],
        body.dark-mode aside[class*="bg-light"],
        body.dark-mode header[class*="bg-light"],
        body.dark-mode footer[class*="bg-light"] {
            background-color: #2d2d2d !important;
        }

        body.dark-mode .border,
        body.dark-mode .border-top,
        body.dark-mode .border-end,
        body.dark-mode .border-bottom,
        body.dark-mode .border-start {
            border-color: #3d3d3d !important;
        }

        body.dark-mode .shadow-sm,
        body.dark-mode .shadow,
        body.dark-mode .shadow-lg {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.4) !important;
        }

        body.dark-mode input.form-control,
        body.dark-mode select.form-control,
        body.dark-mode select.form-select,
        body.dark-mode textarea.form-control {
            background-color: #3d3d3d;
            border-color: #4d4d4d;
            color: #ffffff;
        }

        body.dark-mode .form-control[readonly],
        body.dark-mode .form-control:disabled,
        body.dark-mode .form-control[disabled] {
            background-color: #2d2d2d;
        }

        body.dark-mode .offcanvas,
        body.dark-mode .offcanvas-lg,
        body.dark-mode .offcanvas-md,
        body.dark-mode .offcanvas-sm,
        body.dark-mode .offcanvas-xl,
        body.dark-mode .offcanvas-xxl {
            background-color: #2d2d2d;
        }

        body.dark-mode .toast,
        body.dark-mode .toast-header {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
            color: #ffffff;
        }

        body.dark-mode .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        body.dark-mode hr {
            border-color: #3d3d3d;
        }

        /* লগইন এবং রেজিস্ট্রেশন পেজের রেসপন্সিভ স্টাইল */
        @media (max-width: 576px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .card {
                margin-top: 1rem;
            }
            
            .form-control {
                font-size: 1rem;
                padding: 0.5rem 0.75rem;
            }
            
            .btn {
                font-size: 1rem;
            }
        }
        
        /* মোবাইল ডিভাইসের জন্য লগইন/রেজিস্ট্রেশন ফর্ম স্টাইল */
        @media (max-width: 480px) {
            .card-body {
                padding: 1rem;
            }
            
            .form-label {
                font-size: 0.9rem;
                margin-bottom: 0.3rem;
            }
            
            .form-control {
                margin-bottom: 0.5rem;
            }
            
            .btn {
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
            }
        }
        
        /* কম্প্যাক্ট ফর্ম স্টাইল */
        .auth-form .form-group {
            margin-bottom: 1rem;
        }
        
        .auth-form .form-control {
            border-radius: 0.25rem;
        }
        
        .auth-form .btn {
            border-radius: 0.25rem;
        }
        
        /* লগইন এবং রেজিস্ট্রেশন পেজের স্টাইল */
        .auth-form .card-header {
            border-bottom: none;
        }
        
        .auth-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(254, 91, 86, 0.25);
        }
        
        /* আরও সুন্দর ফর্ম স্টাইল */
        .auth-form .form-control {
            padding: 0.6rem 0.75rem;
            transition: all 0.3s ease;
        }
        
        .auth-form .form-control:hover {
            border-color: var(--primary-color);
        }
        
        .auth-form .btn-primary {
            transition: all 0.3s ease;
        }
        
        .auth-form .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(254, 91, 86, 0.3);
        }
        
        /* কার্ডের জন্য সুন্দর শ্যাডো এফেক্ট */
        .card.shadow-sm {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08) !important;
            transition: all 0.3s ease;
        }
        
        /* ডার্ক মোডে ফর্ম স্টাইল */
        body.dark-mode .auth-form .form-control {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
            color: #ffffff;
        }
        
        body.dark-mode .auth-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(254, 91, 86, 0.25);
        }
        
        body.dark-mode .card.shadow-sm {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3) !important;
        }
        
        /* ইমেইল ভেরিফিকেশন ব্যাজ স্টাইল */
        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            font-weight: 500;
        }
        
        .badge.bg-success {
            background-color: #28a745 !important;
        }
        
        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }
        
        a.badge {
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        a.badge:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }
        
        body.dark-mode .badge.bg-warning {
            color: #212529 !important;
        }
        
        /* প্রফেশনাল লুক এবং টেক্সট সাইজ */
        .fs-7 {
            font-size: 0.8rem !important;
        }
        
        .fs-8 {
            font-size: 0.7rem !important;
        }
        
        .card {
            border-radius: 0.5rem;
            overflow: hidden;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            border-bottom: none;
            background-color: transparent;
        }
        
        .btn {
            border-radius: 0.375rem;
            font-size: 0.85rem;
            padding: 0.375rem 0.75rem;
        }
        
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        .form-control, .form-select {
            font-size: 0.85rem;
            border-radius: 0.375rem;
        }
        
        .form-control-sm, .form-select-sm {
            font-size: 0.75rem;
        }
        
        .form-label {
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
            color: #6c757d;
        }
        
        /* টেবিল স্টাইল */
        .table {
            font-size: 0.85rem;
        }
        
        .table th {
            font-weight: 500;
            color: #6c757d;
        }
        
        /* ডার্ক মোড অ্যাডজাস্টমেন্ট */
        body.dark-mode .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.2);
        }
        
        body.dark-mode .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
        }
        
        body.dark-mode .form-label {
            color: #adb5bd;
        }
        
        body.dark-mode .table th {
            color: #adb5bd;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="app">
        @auth
            <!-- সাইড মেনু -->
            <div class="side-menu" id="sideMenu">
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-user-circle me-2" style="font-size: 2rem;"></i>
                        <div>
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                            
                            @if(Auth::user()->email_verified_at)
                                <div class="mt-1">
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> ইমেইল ভেরিফাইড</span>
                                </div>
                            @else
                                <div class="mt-1">
                                    <a href="{{ route('verification.notice') }}" class="badge bg-warning text-dark text-decoration-none">
                                        <i class="fas fa-exclamation-circle me-1"></i> ভেরিফাই করুন
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-user-edit me-1"></i>{{ __('app.profile_edit') }}
                    </a>
                </div>
                <div class="p-3">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="{{ route('settings.index') }}">
                                <i class="fas fa-cog me-2"></i>{{ __('app.settings') }}
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="{{ route('help.desk') }}">
                                <i class="fas fa-headset me-2"></i>{{ __('app.help_desk') }}
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="{{ route('privacy.policy') }}">
                                <i class="fas fa-shield-alt me-2"></i>{{ __('app.privacy_policy') }}
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="{{ route('about.us') }}">
                                <i class="fas fa-info-circle me-2"></i>{{ __('app.about_us') }}
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>{{ __('app.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="side-menu-backdrop" id="sideMenuBackdrop"></div>
            
            <!-- মেনু আইকন -->
            <div class="menu-icon" id="toggleSideMenu">
                <i class="fas fa-bars"></i>
            </div>
            
            <div class="container mt-3">
                <div class="row">
                    <div class="col-12">
                        <!-- টোটাল ব্যালেন্স কার্ড -->
                        <div class="total-balance-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h6 class="mb-1 text-white-50 fs-7">{{ __('app.total_balance') }}</h6>
                                    <h3 class="mb-0 text-white fw-bold">৳ {{ number_format(App\Models\Account::where('user_id', Auth::id())->where('type', 'Cash')->sum('current_balance'), 2) }}</h3>
                                    <small class="text-white-50">{{ __('app.cash') }}</small>
                                </div>
                               
                            </div>
                            
                            <!-- ট্রানজেকশন বাটন -->
                            <div class="transaction-buttons">
                                <button type="button" class="btn-transaction income-btn quick-transaction-btn" data-bs-toggle="modal" data-bs-target="#quickTransactionModal" data-type="income">
                                    <span class="btn-icon"><i class="fas fa-plus"></i></span>
                                    <span class="btn-text">{{ __('app.add_income') }}</span>
                                </button>
                                <button type="button" class="btn-transaction expense-btn quick-transaction-btn" data-bs-toggle="modal" data-bs-target="#quickTransactionModal" data-type="expense">
                                    <span class="btn-icon"><i class="fas fa-minus"></i></span>
                                    <span class="btn-text">{{ __('app.add_expense') }}</span>
                                </button>
                            </div>
                        </div>
                        <main>
                            @yield('content')
                        </main>
                    </div>
                </div>
            </div>
            
            <!-- ফ্লোটিং অ্যাকশন বাটন -->
            <div class="floating-action-btn" id="fabBtn">
                <i class="fas fa-plus"></i>
            </div>
            
            <!-- পপআপ মেনু -->
            <div class="popup-menu" id="popupMenu">
                <button class="menu-item quick-transaction-btn" data-type="income" data-bs-toggle="modal" data-bs-target="#quickTransactionModal">
                    <i class="fas fa-arrow-down income-text"></i>
                    <span>{{ __('app.add_income') }}</span>
                </button>
                <button class="menu-item quick-transaction-btn" data-type="expense" data-bs-toggle="modal" data-bs-target="#quickTransactionModal">
                    <i class="fas fa-arrow-up expense-text"></i>
                    <span>{{ __('app.add_expense') }}</span>
                </button>
                <a href="{{ route('loans.create') }}" class="menu-item">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>{{ __('app.add_loan') }}</span>
                </a>
                <a href="{{ route('transactions.create', ['type' => 'transfer']) }}" class="menu-item">
                    <i class="fas fa-exchange-alt"></i>
                    <span>{{ __('app.transfer') }}</span>
                </a>
            </div>
            
            <!-- বটম নেভিগেশন বার -->
            <nav class="bottom-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>{{ __('app.dashboard') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('accounts.*') ? 'active' : '' }}" href="{{ route('accounts.index') }}">
                            <i class="fas fa-wallet"></i>
                            <span>{{ __('app.accounts') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                            <i class="fas fa-exchange-alt"></i>
                            <span>{{ __('app.transactions') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="fas fa-tags"></i>
                            <span>{{ __('app.categories') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>{{ __('app.reports') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('loans.*') ? 'active' : '' }}" href="{{ route('loans.index') }}">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>{{ __('লোন') }}</span>
                        </a>
                    </li>
                </ul>
            </nav>
        @else
            @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('password.request') && !request()->routeIs('password.reset') && !request()->routeIs('verification.notice'))
                <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div class="container">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <i class="fas fa-book-open me-2"></i>{{ config('app.name', 'AmarKhata') }}
                        </a>

                        <!-- Right Side Of Navbar -->
                        <div class="d-flex">
                            <div>
                                @if (Route::has('login'))
                                    <a class="btn btn-sm btn-outline-primary me-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @endif

                                @if (Route::has('register'))
                                    <a class="btn btn-sm btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </nav>
            @endif
            <main class="py-4">
                @yield('content')
            </main>
        @endauth
    </div>

    @auth
        @include('transactions.quick_add')
    @endauth

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ডার্ক মোড স্টেট লোড
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                document.body.classList.add('dark-mode');
            }
            
            // সাইড মেনু টগল স্ক্রিপ্ট
            const toggleSideMenu = document.getElementById('toggleSideMenu');
            const sideMenu = document.getElementById('sideMenu');
            const sideMenuBackdrop = document.getElementById('sideMenuBackdrop');
            
            if (toggleSideMenu && sideMenu && sideMenuBackdrop) {
                toggleSideMenu.addEventListener('click', function() {
                    sideMenu.classList.add('show');
                    sideMenuBackdrop.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
                
                sideMenuBackdrop.addEventListener('click', function() {
                    sideMenu.classList.remove('show');
                    sideMenuBackdrop.classList.remove('show');
                    document.body.style.overflow = '';
                });
            }
        
            // ফ্লোটিং অ্যাকশন বাটন এবং পপআপ মেনু স্ক্রিপ্ট
            const fabBtn = document.getElementById('fabBtn');
            const popupMenu = document.getElementById('popupMenu');
            
            if (fabBtn && popupMenu) {
                fabBtn.addEventListener('click', function() {
                    popupMenu.classList.toggle('show');
                });
                
                document.addEventListener('click', function(event) {
                    if (!fabBtn.contains(event.target) && !popupMenu.contains(event.target)) {
                        popupMenu.classList.remove('show');
                    }
                });
            }
            
            // বটম নেভিগেশন হাইলাইট ফিক্স
            const currentPath = window.location.pathname;
            const bottomNavLinks = document.querySelectorAll('.bottom-nav .nav-link');
            
            bottomNavLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href) {
                    const hrefPath = new URL(href, window.location.origin).pathname;
                    
                    // খুব সহজ মেচিং বদলে বিস্তারিত মেচিং ব্যবহার
                    if (
                        // এগজ্যাক্ট মেচ
                        currentPath === hrefPath ||
                        // যদি currentPath হেডার-এর সাথে শুরু হয়
                        (hrefPath !== '/' && currentPath.startsWith(hrefPath)) ||
                        // ট্রানজেকশন টাইপ ম্যাচিং - URL রাউট অনুযায়ী
                        (hrefPath.includes('transactions') && currentPath.includes('transactions')) ||
                        (hrefPath.includes('accounts') && currentPath.includes('accounts')) ||
                        (hrefPath.includes('categories') && currentPath.includes('categories')) ||
                        (hrefPath.includes('reports') && currentPath.includes('reports'))
                    ) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                }
            });
        });

        // সেট স্টোরেজ কুকি
        function setCookie(name, value, days) {
            var expires = '';
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + (value || '') + expires + '; path=/';
        }

        // লোকালস্টোরেজ থেকে ভাষা সেট করা জাভাস্ক্রিপ্ট ফাংশন 
        // এটি পুরোনো জাভাস্ক্রিপ্ট বেসড ভাষা পরিবর্তন সমর্থন করতে রাখা হয়েছে।
        function changeLanguage(lang) {
            localStorage.setItem('preferred_language', lang);
            setCookie('preferred_language', lang, 365);
            
            // ভাষা পরিবর্তনের জন্য সার্ভারে অনুরোধ পাঠান
            window.location.href = "{{ url('language') }}/" + lang;
        }
    </script>
    @stack('scripts')
</body>
</html> 