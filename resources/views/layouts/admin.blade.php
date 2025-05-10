<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản trị') - WebChatGPT Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1.25rem;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }

        .main-content {
            padding: 20px;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        .table {
            vertical-align: middle;
        }

        /* Notification badge styles */
        .badge.rounded-pill {
            position: relative;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h5 class="mb-0">WebChatGPT</h5>
                        <div class="text-muted small">Quản trị hệ thống</div>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                                <i class="fas fa-users"></i> Người dùng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-folder"></i> Danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.packages') ? 'active' : '' }}" href="{{ route('admin.packages') }}">
                                <i class="fas fa-box"></i> Gói dịch vụ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.subscriptions') ? 'active' : '' }}" href="{{ route('admin.subscriptions') }}">
                                <i class="fas fa-credit-card"></i> Đăng ký
                                @if(isset($pendingSubscriptionsCount) && $pendingSubscriptionsCount > 0)
                                    <span class="badge bg-danger rounded-pill ms-2">{{ $pendingSubscriptionsCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}" href="{{ route('admin.messages') }}">
                                <i class="fas fa-comments"></i> Tin nhắn
                                @if(isset($unreadAdminMessagesCount) && $unreadAdminMessagesCount > 0)
                                    <span class="badge bg-danger rounded-pill ms-2">{{ $unreadAdminMessagesCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.auto-replies*') ? 'active' : '' }}" href="{{ route('admin.auto-replies') }}">
                                <i class="fas fa-reply-all"></i> Trả lời tự động
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.accounts*') ? 'active' : '' }}" href="{{ route('admin.accounts.index') }}">
                                <i class="fas fa-key"></i> Quản lý tài khoản
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.referrals*') ? 'active' : '' }}" href="{{ route('admin.referrals') }}">
                                <i class="fas fa-user-friends"></i> Quản lý giới thiệu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.promotions*') ? 'active' : '' }}" href="{{ route('admin.promotions.index') }}">
                                <i class="fas fa-percent"></i> Khuyến mãi
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                <i class="fas fa-external-link-alt"></i> Xem trang chủ
                            </a>
                        </li>
                    </ul>

                    <hr class="my-3">

                    <form action="{{ route('logout') }}" method="POST" class="d-grid px-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top navbar -->
                <nav class="navbar navbar-expand-lg navbar-light mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="d-flex align-items-center ms-auto">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page content -->
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
