@extends('layouts.app')

@section('title', 'Quản lý giới thiệu - WebChatGPT')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="dashboard-sidebar p-4">
                <div class="text-center mb-4">
                    <img src="https://placehold.co/100x100" alt="User Avatar" class="rounded-circle mb-3">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                </div>

                <hr>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Tổng quan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('chat') }}">
                            <i class="fas fa-comments"></i> Chat với AI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('referrals') }}">
                            <i class="fas fa-user-friends"></i> Giới thiệu bạn bè
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i> Cài đặt
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </li>
                </ul>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <h2 class="mb-4">Chương trình giới thiệu bạn bè</h2>

            <!-- Referral Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stat-card bg-white">
                        <div class="stat-icon bg-primary text-white">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <h3 class="fs-4 mb-1">{{ $referrals->count() }}</h3>
                        <p class="text-muted mb-0">Người đã giới thiệu</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-white">
                        <div class="stat-icon bg-success text-white">
                            <i class="fas fa-calendar-plus fa-lg"></i>
                        </div>
                        <h3 class="fs-4 mb-1">{{ $totalDaysReceived }} ngày</h3>
                        <p class="text-muted mb-0">Thời gian đã nhận</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-white">
                        <div class="stat-icon bg-info text-white">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                        <h3 class="fs-4 mb-1">{{ $pendingDays }} ngày</h3>
                        <p class="text-muted mb-0">Thời gian chờ duyệt</p>
                    </div>
                </div>
            </div>

            <!-- Referral Link -->
            <div class="card dashboard-card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Liên kết giới thiệu của bạn</h5>
                </div>
                <div class="card-body">
                    <p>Chia sẻ liên kết này với bạn bè để nhận thêm 1 tuần sử dụng miễn phí khi họ đăng ký gói dịch vụ.</p>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="referral-link" value="{{ route('register') }}?ref={{ $user->referral_code }}" readonly>
                        <button class="btn btn-primary" type="button" id="copy-link">
                            <i class="fas fa-copy"></i> Sao chép
                        </button>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Mã giới thiệu của bạn: <strong>{{ $user->referral_code }}</strong>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('register') . '?ref=' . $user->referral_code) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fab fa-facebook-f me-2"></i> Chia sẻ Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('register') . '?ref=' . $user->referral_code) }}&text=Đăng ký WebChatGPT với mã giới thiệu của tôi" target="_blank" class="btn btn-outline-info">
                            <i class="fab fa-twitter me-2"></i> Chia sẻ Twitter
                        </a>
                    </div>
                </div>
            </div>

            <!-- Referral History -->
            <div class="card dashboard-card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Lịch sử giới thiệu</h5>
                </div>
                <div class="card-body">
                    @if($referrals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Người dùng</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referrals as $referral)
                                        <tr>
                                            <td>{{ $referral->name }}</td>
                                            <td>{{ $referral->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @if($referral->subscriptions()->where('active', true)->exists())
                                                    <span class="badge bg-success">Đã kích hoạt</span>
                                                @else
                                                    <span class="badge bg-warning">Chưa kích hoạt</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p>Bạn chưa giới thiệu người dùng nào.</p>
                            <p>Hãy chia sẻ liên kết giới thiệu của bạn để nhận thêm thời gian sử dụng!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Commission History -->
            <div class="card dashboard-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Lịch sử phần thưởng</h5>
                </div>
                <div class="card-body">
                    @if($commissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Người dùng</th>
                                        <th>Gói dịch vụ</th>
                                        <th>Phần thưởng</th>
                                        <th>Ngày</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commissions as $commission)
                                        <tr>
                                            <td>{{ $commission->referred->name }}</td>
                                            <td>{{ $commission->subscription->package->name }}</td>
                                            <td>
                                                @if($commission->reward_type == 'extension')
                                                    <span class="badge bg-success">+{{ $commission->reward_days }} ngày sử dụng</span>
                                                @else
                                                    {{ number_format($commission->amount, 0, ',', '.') }} VNĐ
                                                @endif
                                            </td>
                                            <td>{{ $commission->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @if($commission->status == 'paid')
                                                    <span class="badge bg-success">Đã thanh toán</span>
                                                @elseif($commission->status == 'pending')
                                                    <span class="badge bg-warning">Chờ duyệt</span>
                                                @else
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                            <p>Bạn chưa có phần thưởng nào.</p>
                            <p>Hãy giới thiệu bạn bè đăng ký gói dịch vụ để nhận thêm thời gian sử dụng!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const copyButton = document.getElementById('copy-link');
        const referralLink = document.getElementById('referral-link');

        copyButton.addEventListener('click', function() {
            referralLink.select();
            document.execCommand('copy');

            // Change button text temporarily
            const originalText = copyButton.innerHTML;
            copyButton.innerHTML = '<i class="fas fa-check"></i> Đã sao chép';

            setTimeout(function() {
                copyButton.innerHTML = originalText;
            }, 2000);
        });
    });
</script>
@endsection

@section('styles')
<style>
    .dashboard-sidebar {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .dashboard-sidebar .nav-link {
        color: #333;
        padding: 12px 20px;
        border-radius: 5px;
        margin-bottom: 5px;
        transition: all 0.3s ease;
    }

    .dashboard-sidebar .nav-link:hover {
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
    }

    .dashboard-sidebar .nav-link.active {
        background-color: var(--primary-color);
        color: white;
    }

    .dashboard-sidebar .nav-link i {
        width: 24px;
        text-align: center;
        margin-right: 10px;
    }

    .stat-card {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        position: relative;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .dashboard-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .dashboard-card .card-header {
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
    }
</style>
@endsection
