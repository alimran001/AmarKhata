@extends('layouts.app')

@section('title', 'বিভাগ সম্পাদনা')

@section('content')
<style>
    .form-control:focus {
        border-color: #E4BE06;
        box-shadow: 0 0 0 0.25rem rgba(228, 190, 6, 0.25);
    }
    .btn-primary {
        background-color: #FE5B56;
        border-color: #FE5B56;
    }
    .btn-primary:hover {
        background-color: #e04b46;
        border-color: #e04b46;
    }
    .btn-secondary {
        background-color: #E4BE06;
        border-color: #E4BE06;
        color: #212529;
    }
    .btn-secondary:hover {
        background-color: #c5a305;
        border-color: #c5a305;
        color: #212529;
    }
    .icon-selection.selected {
        border-color: #FE5B56 !important;
        background-color: rgba(254, 91, 86, 0.1) !important;
    }
    .form-control {
        border-color: #E4BE06;
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">বিভাগ সম্পাদনা</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> বিভাগ তালিকা
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card mb-3" style="border-color: #E4BE06;">
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">বিভাগের নাম <span style="color: #FE5B56;">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">বিভাগের ধরণ</label>
                    <div class="form-control bg-light disabled">
                        {{ $category->type == 'income' ? 'আয়' : 'ব্যয়' }}
                    </div>
                    <div class="form-text">বিভাগের ধরণ পরিবর্তন করা যাবে না</div>
                </div>
                
                <div class="mb-3">
                    <label for="color" class="form-label">রং</label>
                    <div class="d-flex align-items-center">
                        <input type="color" name="color" id="color" value="{{ old('color', $category->color ?? '#E4BE06') }}" class="form-control form-control-color">
                        <span class="ms-2">এই রঙটি বিভাগের জন্য ব্যবহার করা হবে</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">আইকন</label>
                    <div class="row row-cols-4 g-2 mb-2" id="icon-container">
                        @php
                            $icons = [
                                'fa-home', 'fa-car', 'fa-utensils', 'fa-shopping-cart', 
                                'fa-medkit', 'fa-bus', 'fa-plane', 'fa-graduation-cap',
                                'fa-gamepad', 'fa-music', 'fa-book', 'fa-gift',
                                'fa-coffee', 'fa-briefcase', 'fa-wrench', 'fa-users',
                                'fa-tv', 'fa-mobile-alt', 'fa-laptop', 'fa-credit-card',
                                'fa-money-bill-alt', 'fa-piggy-bank', 'fa-chart-line', 'fa-university'
                            ];
                        @endphp
                        
                        @foreach($icons as $icon)
                            <div class="col">
                                <div class="icon-selection p-3 border rounded text-center {{ (old('icon', $category->icon) == $icon) ? 'selected' : '' }}" data-icon="{{ $icon }}" style="border-color: #E4BE06; cursor: pointer;">
                                    <i class="fas {{ $icon }} fa-lg" style="color: #E4BE06;"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="icon" id="icon_input" value="{{ old('icon', $category->icon) }}">
                    <div class="form-text">আইকন নির্বাচন করতে ক্লিক করুন</div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i> আপডেট করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorInput = document.getElementById('color');
        const iconSelections = document.querySelectorAll('.icon-selection');
        const iconInput = document.getElementById('icon_input');
        
        // Handle icon selection
        iconSelections.forEach(selection => {
            selection.addEventListener('click', function() {
                // Remove active class from all icons
                iconSelections.forEach(s => {
                    s.classList.remove('selected');
                });
                
                // Add active class to selected icon
                this.classList.add('selected');
                
                // Update hidden input value
                iconInput.value = this.dataset.icon;
                
                // Update icons color
                updateIconsColor(colorInput.value);
            });
        });
        
        // Handle color change
        colorInput.addEventListener('input', function() {
            updateIconsColor(this.value);
        });
        
        // Initialize icons with current color
        updateIconsColor(colorInput.value);
        
        // Function to update icons color
        function updateIconsColor(color) {
            document.querySelectorAll('.icon-selection i').forEach(icon => {
                icon.style.color = color;
            });
        }
    });
</script>
@endpush
@endsection 