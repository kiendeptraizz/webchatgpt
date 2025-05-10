@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* Card Styles */
    .stat-card {
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        overflow: hidden;
        background: linear-gradient(to right bottom, #ffffff, #f8f9fa);
    }
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to right, var(--bs-primary), var(--bs-info));
        opacity: 0;
        transition: opacity 0.3s;
    }
    .stat-card:hover::after {
        opacity: 1;
    }

    /* Icon Styles */
    .stat-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .stat-icon::before {
        content: '';
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
        transform: rotate(35deg);
        transition: transform 0.5s;
    }
    .stat-card:hover .stat-icon::before {
        transform: rotate(125deg);
    }

    /* Progress Bar Styles */
    .progress-thin {
        height: 6px;
        border-radius: 6px;
        overflow: hidden;
        background-color: rgba(0, 0, 0, 0.05);
    }
    .progress-bar {
        position: relative;
        overflow: hidden;
    }
    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
        animation: progress-shine 2s infinite;
    }

    /* Chart Styles */
    .chart-container {
        position: relative;
        height: 320px;
        margin: 10px 0;
    }
    .chart-card {
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }
    .chart-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }
    .chart-card .card-header {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 15px 20px;
    }

    /* Table Styles */
    .table-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: none;
    }
    .table-card .card-header {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 15px 20px;
    }
    .table-hover tbody tr {
        transition: all 0.2s;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transform: translateX(5px);
    }

    /* Animation */
    @keyframes progress-shine {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }

    /* Badge Styles */
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
        border-radius: 6px;
    }

    /* Button Styles */
    .btn-outline-primary {
        border-width: 2px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-outline-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
    }

    /* Gradient Text */
    .gradient-text {
        background: linear-gradient(45deg, var(--bs-primary), var(--bs-info));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 700;
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 gradient-text mb-1">Dashboard</h1>
        <p class="text-muted">Tổng quan hoạt động kinh doanh</p>
    </div>
    <div class="d-flex gap-2">
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-calendar-alt me-2"></i>Tháng này
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Hôm nay</a></li>
                <li><a class="dropdown-item" href="#">Tuần này</a></li>
                <li><a class="dropdown-item active" href="#">Tháng này</a></li>
                <li><a class="dropdown-item" href="#">Quý này</a></li>
                <li><a class="dropdown-item" href="#">Năm nay</a></li>
            </ul>
        </div>
        <a href="{{ route('admin.reports.subscriptions') }}" class="btn btn-outline-primary">
            <i class="fas fa-download me-2"></i>Xuất báo cáo
        </a>
    </div>
</div>

<!-- Thống kê tổng quan -->
<div class="row">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="d-block text-muted fw-light mb-1">Doanh thu tuần qua</span>
                        <h3 class="mb-0 fw-bold">{{ number_format($weeklyRevenue / 1000000, 1, ',', '.') }} triệu</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 stat-icon">
                        <i class="fas fa-chart-line fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="progress progress-thin mb-3">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 78%"></div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success bg-opacity-10 text-success me-2">
                        <i class="fas fa-arrow-up me-1"></i>12%
                    </span>
                    <span class="text-muted small">so với tuần trước</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="d-block text-muted fw-light mb-1">Tài khoản đã bán</span>
                        <h3 class="mb-0 fw-bold">{{ $accountsSold }}</h3>
                        <p class="text-muted small mt-1">Số tài khoản: <span class="text-success fw-bold">{{ config('admin_stats.accounts_sold') }}</span></p>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-4 stat-icon">
                        <i class="fas fa-user-check fa-2x text-success"></i>
                    </div>
                </div>
                <div class="progress progress-thin mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success bg-opacity-10 text-success me-2">
                        <i class="fas fa-arrow-up me-1"></i>8%
                    </span>
                    <span class="text-muted small">so với tháng trước</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="d-block text-muted fw-light mb-1">Tổng doanh thu</span>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalRevenue / 1000000, 1, ',', '.') }} triệu</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-4 stat-icon">
                        <i class="fas fa-money-bill-wave fa-2x text-info"></i>
                    </div>
                </div>
                <div class="progress progress-thin mb-3">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 85%"></div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success bg-opacity-10 text-success me-2">
                        <i class="fas fa-arrow-up me-1"></i>15%
                    </span>
                    <span class="text-muted small">so với tháng trước</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="d-block text-muted fw-light mb-1">Tổng chi phí</span>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalCost / 1000000, 1, ',', '.') }} triệu</h3>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded-4 stat-icon">
                        <i class="fas fa-tags fa-2x text-danger"></i>
                    </div>
                </div>
                <div class="progress progress-thin mb-3">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $totalRevenue > 0 ? ($totalCost / $totalRevenue) * 100 : 0 }}%"></div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-danger bg-opacity-10 text-danger me-2">
                        <i class="fas fa-chart-pie me-1"></i>{{ $totalRevenue > 0 ? number_format(($totalCost / $totalRevenue) * 100, 0) : 0 }}%
                    </span>
                    <span class="text-muted small">của doanh thu</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="d-block text-muted fw-light mb-1">Tổng lợi nhuận</span>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalProfit / 1000000, 1, ',', '.') }} triệu</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-4 stat-icon">
                        <i class="fas fa-chart-line fa-2x text-success"></i>
                    </div>
                </div>
                <div class="progress progress-thin mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0 }}%"></div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success bg-opacity-10 text-success me-2">
                        <i class="fas fa-chart-pie me-1"></i>{{ $totalRevenue > 0 ? number_format(($totalProfit / $totalRevenue) * 100, 0) : 0 }}%
                    </span>
                    <span class="text-muted small">tỷ suất lợi nhuận</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="d-block text-muted fw-light mb-1">Số người mua</span>
                        <h3 class="mb-0 fw-bold">{{ $totalBuyers }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 stat-icon">
                        <i class="fas fa-users fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="progress progress-thin mb-3">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 60%"></div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success bg-opacity-10 text-success me-2">
                        <i class="fas fa-arrow-up me-1"></i>5%
                    </span>
                    <span class="text-muted small">so với tháng trước</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê chi tiết -->
<div class="row mt-4">
    <div class="col-md-8">
        <div class="card chart-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold">Doanh thu theo thời gian</h5>
                    <p class="text-muted small mb-0">Biểu đồ doanh thu theo ngày trong tuần</p>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Ngày</button>
                    <button type="button" class="btn btn-sm btn-primary">Tuần</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Tháng</button>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-primary bg-opacity-10 rounded-circle me-2">
                            <i class="fas fa-arrow-up text-primary"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted small">Tổng doanh thu</span>
                            <span class="fw-bold">{{ number_format(array_sum($revenueData) / 1000, 0, ',', '.') }}K</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-success bg-opacity-10 rounded-circle me-2">
                            <i class="fas fa-chart-line text-success"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted small">Trung bình mỗi ngày</span>
                            <span class="fw-bold">{{ number_format(array_sum($revenueData) / count($revenueData) / 1000, 0, ',', '.') }}K</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-info bg-opacity-10 rounded-circle me-2">
                            <i class="fas fa-trophy text-info"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted small">Ngày cao nhất</span>
                            <span class="fw-bold">{{ number_format(max($revenueData) / 1000, 0, ',', '.') }}K</span>
                        </div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card chart-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">Phân bổ gói dịch vụ</h5>
                <p class="text-muted small mb-0">Tỷ lệ đăng ký theo gói dịch vụ</p>
            </div>
            <div class="card-body p-4">
                <div class="chart-container">
                    <canvas id="packageChart"></canvas>
                </div>
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <span class="d-inline-block rounded-circle me-2" style="width: 12px; height: 12px; background-color: #0d6efd;"></span>
                            <span>Gói Cơ Bản (69K)</span>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $basicPackagePercent }}%</span>
                    </div>
                    <div class="progress progress-thin mb-3">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $basicPackagePercent }}%"></div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <span class="d-inline-block rounded-circle me-2" style="width: 12px; height: 12px; background-color: #198754;"></span>
                            <span>Gói Nâng Cao (139K)</span>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success">{{ $advancedPackagePercent }}%</span>
                    </div>
                    <div class="progress progress-thin">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $advancedPackagePercent }}%"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div>
                        <span class="d-block text-muted small">Tổng đăng ký</span>
                        <span class="fw-bold">{{ $totalSubscriptions }}</span>
                    </div>
                    <div>
                        <span class="d-block text-muted small">Đã kích hoạt</span>
                        <span class="fw-bold">{{ $activeSubscriptions }}</span>
                    </div>
                    <div>
                        <span class="d-block text-muted small">Tỷ lệ chuyển đổi</span>
                        <span class="fw-bold">{{ $totalSubscriptions > 0 ? number_format(($activeSubscriptions / $totalSubscriptions) * 100, 0) : 0 }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê người dùng và đăng ký -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold">Người dùng mới nhất</h5>
                    <p class="text-muted small mb-0">{{ $newUsersThisWeek }} người dùng mới trong tuần này</p>
                </div>
                <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-users me-1"></i> Xem tất cả
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Tên</th>
                                <th class="border-0">Email</th>
                                <th class="border-0">Ngày đăng ký</th>
                                <th class="border-0 text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-{{ ['primary', 'success', 'info', 'warning', 'danger'][array_rand(['primary', 'success', 'info', 'warning', 'danger'])] }} bg-opacity-10 text-{{ ['primary', 'success', 'info', 'warning', 'danger'][array_rand(['primary', 'success', 'info', 'warning', 'danger'])] }} me-2">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt text-muted me-2 small"></i>
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold">Đăng ký mới nhất</h5>
                    <p class="text-muted small mb-0">Danh sách đăng ký gói dịch vụ gần đây</p>
                </div>
                <a href="{{ route('admin.subscriptions') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-credit-card me-1"></i> Xem tất cả
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Gói</th>
                                <th class="border-0">Người dùng</th>
                                <th class="border-0">Trạng thái</th>
                                <th class="border-0 text-end">Ngày đăng ký</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Subscription::with(['user', 'package'])->latest()->take(5)->get() as $subscription)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-{{ $subscription->package->price > 100000 ? 'success' : 'primary' }} bg-opacity-10 text-{{ $subscription->package->price > 100000 ? 'success' : 'primary' }} me-2">
                                            <i class="fas fa-{{ $subscription->package->price > 100000 ? 'crown' : 'box' }} small"></i>
                                        </div>
                                        <span class="fw-medium">{{ $subscription->package->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>{{ $subscription->user->name ?? 'Khách' }}</td>
                                <td>
                                    @if($subscription->active)
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-check-circle me-1"></i>Đã kích hoạt
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning">
                                            <i class="fas fa-clock me-1"></i>Chờ xác nhận
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="d-flex align-items-center justify-content-end">
                                        <i class="fas fa-calendar-alt text-muted me-2 small"></i>
                                        {{ $subscription->created_at->format('d/m/Y') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    // Đăng ký plugin datalabels
    Chart.register(ChartDataLabels);

    // Gradient cho biểu đồ doanh thu
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const gradientFill = revenueCtx.createLinearGradient(0, 0, 0, 350);
    gradientFill.addColorStop(0, 'rgba(13, 110, 253, 0.3)');
    gradientFill.addColorStop(0.5, 'rgba(13, 110, 253, 0.15)');
    gradientFill.addColorStop(1, 'rgba(13, 110, 253, 0.01)');

    // Biểu đồ doanh thu
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'],
            datasets: [{
                label: 'Doanh thu (nghìn đồng)',
                data: [{{ implode(', ', array_map(function($value) { return $value / 1000; }, $revenueData)) }}],
                borderColor: '#0d6efd',
                backgroundColor: gradientFill,
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#0d6efd',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#ffffff',
                pointHoverBorderColor: '#0d6efd',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyColor: '#666',
                    bodyFont: {
                        size: 13
                    },
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 5,
                    usePointStyle: true,
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toLocaleString('vi-VN') + 'K';
                        }
                    }
                },
                datalabels: {
                    color: '#0d6efd',
                    align: 'top',
                    offset: 10,
                    font: {
                        weight: 'bold'
                    },
                    formatter: function(value) {
                        return value.toLocaleString('vi-VN') + 'K';
                    },
                    display: function(context) {
                        return context.dataIndex === context.dataset.data.indexOf(Math.max(...context.dataset.data)) ||
                               context.dataIndex === context.dataset.data.indexOf(Math.min(...context.dataset.data));
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: '#666',
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'K';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: '#666'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Biểu đồ phân bổ gói dịch vụ
    const packageCtx = document.getElementById('packageChart').getContext('2d');
    const packageChart = new Chart(packageCtx, {
        type: 'doughnut',
        data: {
            labels: ['Gói Cơ Bản (69K)', 'Gói Nâng Cao (139K)'],
            datasets: [{
                data: [{{ $basicPackagePercent }}, {{ $advancedPackagePercent }}],
                backgroundColor: ['#0d6efd', '#198754'],
                borderWidth: 0,
                hoverOffset: 10,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyColor: '#666',
                    bodyFont: {
                        size: 13
                    },
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 5,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
                        }
                    }
                },
                datalabels: {
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 13
                    },
                    formatter: function(value) {
                        return value + '%';
                    }
                }
            },
            cutout: '75%',
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });

    // Hiệu ứng hover cho các card
    document.querySelectorAll('.stat-card, .chart-card, .table-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.12)';
            this.querySelector('.stat-icon')?.classList.add('pulse');
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
            this.querySelector('.stat-icon')?.classList.remove('pulse');
        });
    });
</script>

<style>
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

    .pulse {
        animation: pulse 1s infinite;
    }

    .table-hover tbody tr {
        transition: all 0.3s;
    }

    .card {
        transition: all 0.3s ease;
    }
</style>
@endsection
