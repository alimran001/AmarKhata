@extends('layouts.app')

@section('title', 'সকল ব্যবহারকারী')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>ব্যবহারকারী ব্যবস্থাপনা</h2>
            <p class="text-muted">সকল ব্যবহারকারীদের তালিকা এবং তাদের ব্যবস্থাপনা করুন।</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="নাম, ইমেইল বা ফোন নম্বর দিয়ে খুঁজুন..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> খুঁজুন
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> রিসেট
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">সকল ব্যবহারকারী ({{ $users->total() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>নাম</th>
                            <th>ইমেইল</th>
                            <th>ফোন</th>
                            <th>যোগদান তারিখ</th>
                            <th class="text-end">পদক্ষেপ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2 bg-primary rounded-circle text-white">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? 'নেই' }}</td>
                                <td>{{ $user->created_at->format('d M, Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> দেখুন
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> সম্পাদনা
                                    </a>
                                    <a href="{{ route('admin.users.change-password', $user) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-key"></i> পাসওয়ার্ড
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">কোন ব্যবহারকারী পাওয়া যায়নি।</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</div>

<style>
    .avatar {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
</style>
@endsection 