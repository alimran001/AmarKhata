@extends('layouts.app')

@section('title', 'বিভাগসমূহ')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">বিভাগসমূহ</h5>
        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> নতুন বিভাগ
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-3" style="border-color: #E4BE06;">
        <div class="card-header text-white py-2" style="background-color: #E4BE06; color: #212529;">
            <h6 class="mb-0">আয়ের বিভাগসমূহ</h6>
        </div>
        
        <ul class="list-group list-group-flush">
            @forelse($categories->where('type', 'income') as $category)
                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                    <div class="d-flex align-items-center">
                        @if($category->icon)
                            <span class="me-2">
                                <i class="fas {{ $category->icon }}" style="color: {{ $category->color ?? '#E4BE06' }}"></i>
                            </span>
                        @else
                            <span class="me-2 d-inline-block rounded-circle" style="width: 10px; height: 10px; background-color: {{ $category->color ?? '#E4BE06' }}"></span>
                        @endif
                        
                        <a href="{{ route('categories.show', $category) }}" class="text-decoration-none text-dark small">
                            {{ $category->name }}
                        </a>
                        
                        @if($category->is_default)
                            <span class="badge ms-1 small" style="background-color: #E4BE06; color: #212529;">ডিফল্ট</span>
                        @endif
                    </div>
                    
                    <div>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm me-1 p-1" style="border-color: #E4BE06; color: #212529;">
                            <i class="fas fa-edit small"></i>
                        </a>
                        
                        @if(!$category->is_default)
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm p-1 btn-outline-danger" onclick="return confirm('আপনি কি এই বিভাগ মুছে ফেলতে চান?')">
                                    <i class="fas fa-trash small"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </li>
            @empty
                <li class="list-group-item text-muted small py-2">কোন আয় বিভাগ পাওয়া যায়নি।</li>
            @endforelse
        </ul>
    </div>

    <div class="card shadow-sm" style="border-color: #FE5B56;">
        <div class="card-header text-white py-2" style="background-color: #FE5B56;">
            <h6 class="mb-0">ব্যয়ের বিভাগসমূহ</h6>
        </div>
        
        <ul class="list-group list-group-flush">
            @forelse($categories->where('type', 'expense') as $category)
                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                    <div class="d-flex align-items-center">
                        @if($category->icon)
                            <span class="me-2">
                                <i class="fas {{ $category->icon }}" style="color: {{ $category->color ?? '#FE5B56' }}"></i>
                            </span>
                        @else
                            <span class="me-2 d-inline-block rounded-circle" style="width: 10px; height: 10px; background-color: {{ $category->color ?? '#FE5B56' }}"></span>
                        @endif
                        
                        <a href="{{ route('categories.show', $category) }}" class="text-decoration-none text-dark small">
                            {{ $category->name }}
                        </a>
                        
                        @if($category->is_default)
                            <span class="badge ms-1 small" style="background-color: #FE5B56;">ডিফল্ট</span>
                        @endif
                    </div>
                    
                    <div>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm me-1 p-1" style="border-color: #FE5B56; color: #FE5B56;">
                            <i class="fas fa-edit small"></i>
                        </a>
                        
                        @if(!$category->is_default)
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm p-1" style="border-color: #FE5B56; color: #FE5B56;" onclick="return confirm('আপনি কি এই বিভাগ মুছে ফেলতে চান?')">
                                    <i class="fas fa-trash small"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </li>
            @empty
                <li class="list-group-item text-muted small py-2">কোন ব্যয় বিভাগ পাওয়া যায়নি।</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection 