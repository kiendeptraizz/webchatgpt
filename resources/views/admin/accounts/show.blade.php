@extends('layouts.admin')

@section('title', 'Chi tiết tài khoản')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Chi tiết tài khoản: {{ $account->username }}</h1>
    <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

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

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin tài khoản</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên tài khoản:</label>
                    <p>{{ $account->username }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Mật khẩu:</label>
                    <p>{{ $account->password }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Giá nhập:</label>
                    <p>{{ $account->cost_price ? number_format($account->cost_price, 0, ',', '.') . ' đ' : 'Chưa nhập' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Loại tài khoản:</label>
                    <p>
                        @if($account->account_type == 'premium')
                            <span class="badge bg-success">Premium</span>
                        @else
                            <span class="badge bg-primary">Standard</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Số người dùng:</label>
                    <p><span class="badge bg-info">{{ $account->current_users }}/{{ $account->max_users }}</span></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Ngày bắt đầu:</label>
                    <p>{{ $account->start_date ? $account->start_date->format('d/m/Y') : 'Không giới hạn' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Ngày kết thúc:</label>
                    <p>{{ $account->end_date ? $account->end_date->format('d/m/Y') : 'Không giới hạn' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái:</label>
                    <p>
                        @if($account->is_active)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Tạm khóa</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Lần cuối sử dụng:</label>
                    <p>{{ $account->last_used_at ? $account->last_used_at->format('d/m/Y H:i') : 'Chưa sử dụng' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả:</label>
                    <p>{{ $account->description ?: 'Không có mô tả' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Ngày tạo:</label>
                    <p>{{ $account->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Cập nhật lần cuối:</label>
                    <p>{{ $account->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAccountModal">
                        <i class="fas fa-edit me-1"></i> Chỉnh sửa
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Người dùng đang sử dụng tài khoản</h5>
                <div>
                    <span class="badge bg-primary me-2">{{ $account->subscriptions->count() }} người dùng</span>
                    @if($account->current_users < $account->max_users)
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#assignUserModal">
                        <i class="fas fa-user-plus"></i> Thêm người dùng
                    </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($account->subscriptions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Gói dịch vụ</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($account->subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->id }}</td>
                                    <td>{{ $subscription->user->name ?? 'Không có' }}</td>
                                    <td>{{ $subscription->package->name ?? 'Không có' }}</td>
                                    <td>{{ $subscription->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $subscription->end_date->format('d/m/Y') }}</td>
                                    <td>
                                        <form action="{{ route('admin.accounts.unassign', $subscription->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy gán tài khoản cho người dùng này?')">
                                                <i class="fas fa-unlink"></i> Hủy gán
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Chưa có người dùng nào được gán cho tài khoản này.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên tài khoản</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $account->username }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu (để trống nếu không thay đổi)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="cost_price" class="form-label">Giá nhập</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="cost_price" name="cost_price" value="{{ $account->cost_price }}" min="0" step="1000">
                            <span class="input-group-text">VNĐ</span>
                        </div>
                        <div class="form-text">Giá nhập tài khoản để tính lợi nhuận</div>
                    </div>
                    <div class="mb-3">
                        <label for="account_type" class="form-label">Loại tài khoản</label>
                        <select class="form-select" id="account_type" name="account_type" required>
                            <option value="standard" {{ $account->account_type == 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="premium" {{ $account->account_type == 'premium' ? 'selected' : '' }}>Premium</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="max_users" class="form-label">Số người dùng tối đa</label>
                        <input type="number" class="form-control" id="max_users" name="max_users" value="{{ $account->max_users }}" min="{{ $account->current_users }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $account->description }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $account->start_date ? $account->start_date->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $account->end_date ? $account->end_date->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $account->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Kích hoạt tài khoản</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Assign User Modal -->
@if($account->current_users < $account->max_users)
<div class="modal fade" id="assignUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm người dùng vào tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.accounts.assign-user') }}" method="POST">
                @csrf
                <input type="hidden" name="account_id" value="{{ $account->id }}">
                <div class="modal-body">
                    <p><strong>Tài khoản:</strong> {{ $account->username }}</p>
                    <p><strong>Số người dùng hiện tại:</strong> {{ $account->current_users }}/{{ $account->max_users }}</p>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Chọn người dùng</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">-- Chọn người dùng --</option>
                            @foreach($availableUsers as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Người dùng sẽ được tạo subscription mới với tài khoản này.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm người dùng</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
