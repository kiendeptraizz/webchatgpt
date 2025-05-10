@extends('layouts.app')

@section('title', 'Dashboard - WebChatGPT')

@section('styles')
<style>
    /* Dashboard Sidebar Styles */
    .dashboard-sidebar {
        background: var(--glass-bg);
        backdrop-filter: blur(var(--glass-blur));
        -webkit-backdrop-filter: blur(var(--glass-blur));
        border: var(--glass-border);
        border-radius: var(--glass-radius);
        box-shadow: var(--glass-shadow);
        transition: all 0.3s ease;
        position: sticky;
        top: 20px;
    }

    .dashboard-sidebar .user-profile {
        position: relative;
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .dashboard-sidebar .user-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .dashboard-sidebar .user-avatar:hover {
        transform: scale(1.05);
        box-shadow: var(--neon-shadow);
    }

    .dashboard-sidebar .user-name {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 5px;
        color: var(--dark-color);
    }

    .dashboard-sidebar .user-plan {
        display: inline-block;
        padding: 5px 15px;
        background: var(--tech-gradient);
        color: white;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 5px;
    }

    .dashboard-sidebar .nav-link {
        color: var(--dark-color);
        padding: 12px 20px;
        border-radius: 8px;
        margin: 5px 10px;
        transition: all 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .dashboard-sidebar .nav-link:hover {
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
        transform: translateX(5px);
    }

    .dashboard-sidebar .nav-link.active {
        background: var(--tech-gradient);
        color: white;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
    }

    .dashboard-sidebar .nav-link i {
        width: 24px;
        text-align: center;
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .dashboard-sidebar .nav-link.text-danger {
        color: var(--danger-color);
    }

    .dashboard-sidebar .nav-link.text-danger:hover {
        background-color: rgba(244, 67, 54, 0.1);
    }

    /* Dashboard Cards */
    .dashboard-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    /* Stats Cards */
    .stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        border-radius: 15px;
        padding: 20px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(255,255,255,0.2);
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        font-size: 24px;
        background: var(--tech-gradient);
        color: white;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }

    .stat-content h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--dark-color);
    }

    .stat-content p {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .stat-card {
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .chat-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .chat-item {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .chat-item:hover {
        background-color: rgba(67, 97, 238, 0.05);
    }

    .chat-item .chat-time {
        font-size: 0.8rem;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="dashboard-sidebar">
                <div class="user-profile">
                    <img src="https://placehold.co/100x100" alt="User Avatar" class="user-avatar">
                    <h5 class="user-name">{{ $user->name }}</h5>
                    @if($activeSubscription)
                        <span class="user-plan">{{ $activeSubscription->package->name }}</span>
                    @else
                        <span class="badge bg-secondary">Chưa đăng ký gói</span>
                    @endif
                </div>

                <div class="p-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Tổng quan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('chat') }}">
                                <i class="fas fa-comments"></i> Chat với tư vấn viên
                                @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unreadMessagesCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('referrals') }}">
                                <i class="fas fa-user-friends"></i> Giới thiệu bạn bè
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-history"></i> Lịch sử chat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog"></i> Cài đặt
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-credit-card"></i> Thanh toán
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-question-circle"></i> Hỗ trợ
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Tổng quan</h2>
                <button class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Chat mới
                </button>
            </div>

            <!-- Stats Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $chatCount }}</h3>
                            <p>Tổng số chat</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--cool-gradient);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-content">
                            @if($activeSubscription)
                                <h3>{{ $daysRemaining }}</h3>
                                <p>Ngày còn lại</p>
                            @else
                                <h3>0</h3>
                                <p>Chưa đăng ký gói</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--warm-gradient);">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="stat-content">
                            @if($activeSubscription)
                                <h3>Không giới hạn</h3>
                                <p>Số lượng câu hỏi</p>
                            @else
                                <h3>-</h3>
                                <p>Chưa đăng ký gói</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Chats -->
            <div class="card dashboard-card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Chat gần đây</h5>
                </div>
                <div class="card-body">
                    <div class="chat-list">
                        @if($recentChats->count() > 0)
                            @foreach($recentChats as $date => $chats)
                                <div class="chat-item">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">{{ Str::limit($chats->first()->content, 40) }}</h6>
                                        <span class="chat-time">{{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="text-muted mb-0">{{ Str::limit($chats->first()->content, 100) }}</p>
                                </div>

                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <p>Bạn chưa có cuộc trò chuyện nào.</p>
                                <a href="{{ route('chat') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-plus me-2"></i> Bắt đầu chat
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('chat') }}" class="text-decoration-none">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <!-- Subscription Info -->
            <div class="card dashboard-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Thông tin gói dịch vụ</h5>
                </div>
                <div class="card-body">
                    @if($activeSubscription)
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Gói hiện tại</h6>
                                <p class="mb-3"><span class="badge bg-primary">{{ $activeSubscription->package->name }}</span></p>

                                <h6>Ngày bắt đầu</h6>
                                <p class="mb-3">{{ $activeSubscription->start_date->format('d/m/Y') }}</p>

                                <h6>Ngày kết thúc</h6>
                                <p class="mb-3">{{ $activeSubscription->end_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Trạng thái</h6>
                                <p class="mb-3"><span class="badge bg-success">Đang hoạt động</span></p>

                                <h6>Phương thức thanh toán</h6>
                                <p class="mb-3">
                                    @if($activeSubscription->payment_method)
                                        {{ $activeSubscription->payment_method == 'bank_transfer' ? 'Chuyển khoản ngân hàng' : $activeSubscription->payment_method }}
                                    @else
                                        Không có thông tin
                                    @endif
                                </p>

                                <h6>Chu kỳ thanh toán</h6>
                                <p class="mb-3">{{ $activeSubscription->end_date->diffInMonths($activeSubscription->start_date) }} tháng</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('home') }}#packages" class="btn btn-outline-primary">Nâng cấp gói</a>
                            <a href="#" class="btn btn-outline-secondary">Thay đổi phương thức thanh toán</a>
                        </div>
                    @elseif($pendingSubscription)
                        <div class="alert alert-warning">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading">Đang chờ xác nhận</h5>
                                    <p class="mb-0">Bạn đã đăng ký gói <strong>{{ $pendingSubscription->package->name }}</strong>. Chúng tôi đang xác nhận thanh toán của bạn.</p>
                                    <p class="mb-0">Trạng thái: <span class="badge bg-warning">Chờ xác nhận</span></p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5>Bạn chưa đăng ký gói dịch vụ nào</h5>
                            <p class="text-muted mb-4">Hãy đăng ký gói dịch vụ để sử dụng đầy đủ tính năng của WebChatGPT</p>
                            <a href="{{ route('home') }}#packages" class="btn btn-primary">
                                <i class="fas fa-shopping-cart me-2"></i> Xem các gói dịch vụ
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
