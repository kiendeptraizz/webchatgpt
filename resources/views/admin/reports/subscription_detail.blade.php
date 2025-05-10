@extends('layouts.admin')

@section('title', 'Báo cáo chi tiết đơn hàng #' . $subscription->id)

@section('styles')
<style>
    .report-card {
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .report-header {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        padding: 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .report-body {
        padding: 25px;
    }

    .report-section {
        margin-bottom: 30px;
    }

    .report-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        color: #333;
    }

    .info-row {
        display: flex;
        margin-bottom: 12px;
    }

    .info-label {
        width: 180px;
        font-weight: 500;
        color: #555;
    }

    .info-value {
        flex: 1;
        color: #333;
    }

    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
        border-radius: 6px;
    }

    .account-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-top: 15px;
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

        .report-card {
            box-shadow: none;
            border: 1px solid #dee2e6;
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
        <h1 class="h3 mb-1">Báo cáo chi tiết đơn hàng #{{ $subscription->id }}</h1>
        <p class="text-muted">Ngày tạo: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <a href="{{ route('admin.subscriptions') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
        <button type="button" class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print me-1"></i> In báo cáo
        </button>
    </div>
</div>

<div class="report-card">
    <div class="report-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Thông tin đơn hàng</h5>
            <p class="text-muted mb-0">Mã đơn hàng: #{{ $subscription->id }}</p>
        </div>
        <div>
            @if($subscription->active)
                <span class="badge bg-success">Đã kích hoạt</span>
            @else
                <span class="badge bg-warning">Chờ xác nhận</span>
            @endif
        </div>
    </div>

    <div class="report-body">
        <!-- Thông tin đơn hàng -->
        <div class="report-section">
            <h6 class="section-title">Thông tin chung</h6>

            <div class="info-row">
                <div class="info-label">Trạng thái:</div>
                <div class="info-value">
                    @if($subscription->active)
                        <span class="badge bg-success">Đã kích hoạt</span>
                    @else
                        <span class="badge bg-warning">Chờ xác nhận</span>
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Ngày đăng ký:</div>
                <div class="info-value">{{ $subscription->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Ngày bắt đầu:</div>
                <div class="info-value">{{ $subscription->start_date->format('d/m/Y') }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Ngày kết thúc:</div>
                <div class="info-value">{{ $subscription->end_date->format('d/m/Y') }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Thời hạn:</div>
                <div class="info-value">{{ $subscription->start_date->diffInDays($subscription->end_date) }} ngày</div>
            </div>

            <div class="info-row">
                <div class="info-label">Phương thức thanh toán:</div>
                <div class="info-value">
                    @if($subscription->payment_method == 'bank_transfer')
                        <span class="badge bg-primary">Chuyển khoản ngân hàng</span>
                    @elseif($subscription->payment_method == 'momo')
                        <span class="badge bg-danger">Ví MoMo</span>
                    @elseif($subscription->payment_method == 'zalopay')
                        <span class="badge bg-info">Zalo</span>
                    @elseif($subscription->payment_method == 'vnpay')
                        <span class="badge bg-success">VNPay</span>
                    @elseif($subscription->payment_method == 'admin_assigned')
                        <span class="badge bg-dark">Admin gán</span>
                    @else
                        <span class="badge bg-secondary">Khác</span>
                    @endif
                </div>
            </div>

            @if($subscription->payment_notes)
            <div class="info-row">
                <div class="info-label">Ghi chú thanh toán:</div>
                <div class="info-value">{{ $subscription->payment_notes }}</div>
            </div>
            @endif
        </div>

        <!-- Thông tin người dùng -->
        <div class="report-section">
            <h6 class="section-title">Thông tin người dùng</h6>

            @if($subscription->user)
                <div class="info-row">
                    <div class="info-label">Tên người dùng:</div>
                    <div class="info-value">{{ $subscription->user->name }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $subscription->user->email }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Số điện thoại (Zalo):</div>
                    <div class="info-value">{{ $subscription->phone ?? 'Không có' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Ngày đăng ký:</div>
                    <div class="info-value">{{ $subscription->user->created_at->format('d/m/Y') }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Vai trò:</div>
                    <div class="info-value">
                        @if($subscription->user->role == 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-primary">Người dùng</span>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> Không tìm thấy thông tin người dùng.
                </div>
            @endif
        </div>

        <!-- Thông tin gói dịch vụ -->
        <div class="report-section">
            <h6 class="section-title">Thông tin gói dịch vụ</h6>

            @if($subscription->package)
                <div class="info-row">
                    <div class="info-label">Tên gói:</div>
                    <div class="info-value">{{ $subscription->package->name }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Giá:</div>
                    <div class="info-value">{{ number_format($subscription->package->price, 0, ',', '.') }} VNĐ</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Mô tả:</div>
                    <div class="info-value">{{ $subscription->package->description }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Số người dùng tối đa:</div>
                    <div class="info-value">{{ $subscription->package->max_users }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Tính năng:</div>
                    <div class="info-value">
                        @if($subscription->package->features)
                            <ul class="mb-0">
                                @foreach(json_decode($subscription->package->features) as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Không có thông tin</span>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> Không tìm thấy thông tin gói dịch vụ.
                </div>
            @endif
        </div>

        <!-- Thông tin tài khoản ChatGPT -->
        <div class="report-section">
            <h6 class="section-title">Thông tin tài khoản ChatGPT</h6>

            @if($subscription->account)
                <div class="account-card">
                    <div class="info-row">
                        <div class="info-label">Tên tài khoản:</div>
                        <div class="info-value">{{ $subscription->account->username }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Mật khẩu:</div>
                        <div class="info-value">{{ $subscription->account->password }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Loại tài khoản:</div>
                        <div class="info-value">
                            @if($subscription->account->account_type == 'premium')
                                <span class="badge bg-success">Premium</span>
                            @else
                                <span class="badge bg-primary">Standard</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Số người dùng:</div>
                        <div class="info-value">
                            <span class="badge bg-info">{{ $subscription->account->current_users }}/{{ $subscription->account->max_users }}</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Ngày bắt đầu:</div>
                        <div class="info-value">{{ $subscription->account->start_date ? $subscription->account->start_date->format('d/m/Y') : 'Không giới hạn' }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Ngày kết thúc:</div>
                        <div class="info-value">{{ $subscription->account->end_date ? $subscription->account->end_date->format('d/m/Y') : 'Không giới hạn' }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Trạng thái:</div>
                        <div class="info-value">
                            @if($subscription->account->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-danger">Tạm khóa</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Lần cuối sử dụng:</div>
                        <div class="info-value">{{ $subscription->account->last_used_at ? $subscription->account->last_used_at->format('d/m/Y H:i') : 'Chưa sử dụng' }}</div>
                    </div>


                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> Chưa có tài khoản ChatGPT nào được gán cho đơn hàng này.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Print Button -->
<button type="button" class="btn btn-primary btn-lg rounded-circle print-button no-print" onclick="window.print()">
    <i class="fas fa-print"></i>
</button>
@endsection
