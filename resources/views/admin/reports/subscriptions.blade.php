@extends('layouts.admin')

@section('title', 'Báo cáo đăng ký')

@section('styles')
<style>
    .report-header {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .stat-card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin-right: 15px;
    }
    
    .table-hover tbody tr {
        transition: all 0.2s;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
    
    .chart-container {
        height: 300px;
    }
    
    .print-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    @media print {
        .no-print {
            display: none !important;
        }
        
        .print-only {
            display: block !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
        
        body {
            padding: 0;
            margin: 0;
        }
        
        .container-fluid {
            width: 100%;
            padding: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Báo cáo đăng ký</h1>
        <p class="text-muted">Thống kê đăng ký từ {{ $startDate->format('d/m/Y') }} đến {{ $endDate->format('d/m/Y') }}</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="fas fa-filter me-1"></i> Lọc báo cáo
        </button>
        <button type="button" class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print me-1"></i> In báo cáo
        </button>
    </div>
</div>

<!-- Thống kê tổng quan -->
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="fas fa-money-bill-wave text-primary"></i>
                    </div>
                    <div>
                        <span class="d-block text-muted small">Tổng doanh thu</span>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h3>
                    </div>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon bg-success bg-opacity-10">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div>
                        <span class="d-block text-muted small">Đăng ký đã kích hoạt</span>
                        <h3 class="mb-0 fw-bold">{{ $activeCount }}</h3>
                    </div>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $subscriptions->count() > 0 ? ($activeCount / $subscriptions->count()) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                    <div>
                        <span class="d-block text-muted small">Đăng ký chờ xác nhận</span>
                        <h3 class="mb-0 fw-bold">{{ $pendingCount }}</h3>
                    </div>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $subscriptions->count() > 0 ? ($pendingCount / $subscriptions->count()) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon bg-info bg-opacity-10">
                        <i class="fas fa-users text-info"></i>
                    </div>
                    <div>
                        <span class="d-block text-muted small">Tổng số đăng ký</span>
                        <h3 class="mb-0 fw-bold">{{ $subscriptions->count() }}</h3>
                    </div>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê theo gói dịch vụ -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Thống kê theo gói dịch vụ</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Gói dịch vụ</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packageStats as $stat)
                            <tr>
                                <td>{{ $stat['name'] }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{ $stat['count'] }}</span>
                                </td>
                                <td class="text-end">{{ number_format($stat['revenue'], 0, ',', '.') }} đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Thống kê theo phương thức thanh toán</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Phương thức</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Tỷ lệ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalPaymentCount = array_sum(array_column($paymentMethodStats, 'count'));
                            @endphp
                            
                            @foreach($paymentMethodStats as $method => $stat)
                            <tr>
                                <td>{{ $stat['name'] }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success">{{ $stat['count'] }}</span>
                                </td>
                                <td class="text-end">
                                    {{ $totalPaymentCount > 0 ? number_format(($stat['count'] / $totalPaymentCount) * 100, 1) : 0 }}%
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

<!-- Danh sách đăng ký -->
<div class="card mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách đăng ký</h5>
        <span class="badge bg-primary">{{ $subscriptions->count() }} đăng ký</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Gói dịch vụ</th>
                        <th>Tài khoản</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Phương thức</th>
                        <th>Ngày đăng ký</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->id }}</td>
                        <td>{{ $subscription->user->name ?? 'Khách' }}</td>
                        <td>{{ $subscription->package->name ?? 'N/A' }}</td>
                        <td>
                            @if($subscription->account)
                                <span class="badge bg-success">{{ $subscription->account->username }}</span>
                            @else
                                <span class="badge bg-secondary">Chưa gán</span>
                            @endif
                        </td>
                        <td>{{ $subscription->start_date->format('d/m/Y') }}</td>
                        <td>{{ $subscription->end_date->format('d/m/Y') }}</td>
                        <td>
                            @if($subscription->active)
                                <span class="badge bg-success">Đã kích hoạt</span>
                            @else
                                <span class="badge bg-warning">Chờ xác nhận</span>
                            @endif
                        </td>
                        <td>
                            @if($subscription->payment_method == 'bank_transfer')
                                <span class="badge bg-primary">Chuyển khoản</span>
                            @elseif($subscription->payment_method == 'momo')
                                <span class="badge bg-danger">MoMo</span>
                            @elseif($subscription->payment_method == 'zalopay')
                                <span class="badge bg-info">Zalo</span>
                            @elseif($subscription->payment_method == 'vnpay')
                                <span class="badge bg-success">VNPay</span>
                            @elseif($subscription->payment_method == 'admin_assigned')
                                <span class="badge bg-dark">Admin gán</span>
                            @else
                                <span class="badge bg-secondary">Khác</span>
                            @endif
                        </td>
                        <td>{{ $subscription->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lọc báo cáo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.reports.subscriptions') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Từ ngày</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Đến ngày</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Tất cả</option>
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Đã kích hoạt</option>
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Áp dụng</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Print Button -->
<button type="button" class="btn btn-primary btn-lg rounded-circle print-button no-print" onclick="window.print()">
    <i class="fas fa-print"></i>
</button>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Thêm mã JavaScript nếu cần
    });
</script>
@endsection
