@extends('layouts.admin')

@section('title', 'Quản lý đăng ký')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/payment-proof.css') }}">
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Quản lý đăng ký</h1>
    <a href="{{ route('admin.reports.subscriptions') }}" class="btn btn-primary">
        <i class="fas fa-file-export me-1"></i> Xuất báo cáo
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Gói dịch vụ</th>
                        <th>Tài khoản</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
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
                                @if($subscription->active)
                                <button type="button" class="btn btn-sm btn-primary ms-1" data-bs-toggle="modal" data-bs-target="#assignAccountModal{{ $subscription->id }}">
                                    <i class="fas fa-link"></i> Gán
                                </button>
                                @endif
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
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewSubscriptionModal{{ $subscription->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('admin.reports.subscription.detail', $subscription->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Xuất báo cáo chi tiết đơn hàng">
                                    <i class="fas fa-file-export"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#activateSubscriptionModal{{ $subscription->id }}" {{ $subscription->active ? 'disabled' : '' }}>
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteSubscriptionModal{{ $subscription->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- View Subscription Modal -->
                            <div class="modal fade" id="viewSubscriptionModal{{ $subscription->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Chi tiết đăng ký</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <h6>Thông tin người dùng</h6>
                                                <p><strong>Tên:</strong> {{ $subscription->user->name ?? 'Khách' }}</p>
                                                <p><strong>Email:</strong> {{ $subscription->user->email ?? 'N/A' }}</p>
                                                <p><strong>Số điện thoại (Zalo):</strong> {{ $subscription->phone ?? 'Không có' }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Thông tin gói dịch vụ</h6>
                                                <p><strong>Tên gói:</strong> {{ $subscription->package->name ?? 'N/A' }}</p>
                                                <p><strong>Giá:</strong> {{ number_format($subscription->package->price ?? 0, 0, ',', '.') }} VNĐ</p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Thông tin đăng ký</h6>
                                                <p><strong>Ngày bắt đầu:</strong> {{ $subscription->start_date->format('d/m/Y') }}</p>
                                                <p><strong>Ngày kết thúc:</strong> {{ $subscription->end_date->format('d/m/Y') }}</p>
                                                <p><strong>Trạng thái:</strong>
                                                    @if($subscription->active)
                                                        <span class="badge bg-success">Đã kích hoạt</span>
                                                    @else
                                                        <span class="badge bg-warning">Chờ xác nhận</span>
                                                    @endif
                                                </p>
                                                <p><strong>Ngày đăng ký:</strong> {{ $subscription->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                            @if($subscription->payment_proof)
                                                <div class="mb-3 payment-proof-container">
                                                    <h6 class="payment-section-header">Bằng chứng thanh toán</h6>
                                                    <div class="text-center">
                                                        <img src="{{ asset('storage/' . $subscription->payment_proof) }}" class="img-fluid payment-proof-image" alt="Bằng chứng thanh toán">
                                                    </div>
                                                    <div class="payment-info mt-2">
                                                        <p><strong>Phương thức thanh toán:</strong>
                                                            @if($subscription->payment_method == 'bank_transfer')
                                                                Chuyển khoản ngân hàng
                                                            @elseif($subscription->payment_method == 'momo')
                                                                Ví MoMo
                                                            @elseif($subscription->payment_method == 'zalopay')
                                                                Zalo
                                                            @elseif($subscription->payment_method == 'vnpay')
                                                                VNPay
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                        @if($subscription->payment_notes)
                                                            <p><strong>Ghi chú:</strong> {{ $subscription->payment_notes }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Activate Subscription Modal -->
                            <div class="modal fade" id="activateSubscriptionModal{{ $subscription->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận kích hoạt</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn kích hoạt đăng ký này?</p>
                                            <p><strong>Người dùng:</strong> {{ $subscription->user->name ?? 'Khách' }}</p>
                                            <p><strong>Gói dịch vụ:</strong> {{ $subscription->package->name ?? 'N/A' }}</p>

                                            @if($subscription->payment_proof)
                                                <div class="mt-3 payment-proof-container">
                                                    <h6 class="payment-section-header">Bằng chứng thanh toán</h6>
                                                    <div class="text-center">
                                                        <img src="{{ asset('storage/' . $subscription->payment_proof) }}" class="img-fluid payment-proof-image" alt="Bằng chứng thanh toán">
                                                    </div>
                                                    <div class="payment-info mt-2">
                                                        <p><strong>Phương thức thanh toán:</strong>
                                                            @if($subscription->payment_method == 'bank_transfer')
                                                                Chuyển khoản ngân hàng
                                                            @elseif($subscription->payment_method == 'momo')
                                                                Ví MoMo
                                                            @elseif($subscription->payment_method == 'zalopay')
                                                                Zalo
                                                            @elseif($subscription->payment_method == 'vnpay')
                                                                VNPay
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('admin.subscriptions.activate', $subscription->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success">Kích hoạt</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Subscription Modal -->
                            <div class="modal fade" id="deleteSubscriptionModal{{ $subscription->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa đăng ký này?</p>
                                            <p><strong>Người dùng:</strong> {{ $subscription->user->name ?? 'Khách' }}</p>
                                            <p><strong>Gói dịch vụ:</strong> {{ $subscription->package->name ?? 'N/A' }}</p>
                                            <p class="text-danger">Hành động này không thể hoàn tác.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Assign Account Modal -->
                            @if($subscription->active && !$subscription->account_id)
                            <div class="modal fade" id="assignAccountModal{{ $subscription->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Gán tài khoản</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.accounts.assign') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
                                            <div class="modal-body">
                                                <p><strong>Người dùng:</strong> {{ $subscription->user->name ?? 'Khách' }}</p>
                                                <p><strong>Gói dịch vụ:</strong> {{ $subscription->package->name ?? 'N/A' }}</p>

                                                <div class="mb-3">
                                                    <label for="account_id{{ $subscription->id }}" class="form-label">Chọn tài khoản</label>
                                                    <select class="form-select" id="account_id{{ $subscription->id }}" name="account_id" required>
                                                        <option value="">-- Chọn tài khoản --</option>
                                                        @foreach(\App\Models\Account::where('is_active', true)->where('current_users', '<', \DB::raw('max_users'))->get() as $account)
                                                            <option value="{{ $account->id }}">
                                                                {{ $account->username }} ({{ $account->current_users }}/{{ $account->max_users }} người dùng)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-primary">Gán tài khoản</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Kích hoạt tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection