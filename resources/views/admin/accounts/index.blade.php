@extends('layouts.admin')

@section('title', 'Quản lý tài khoản')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Quản lý tài khoản</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAccountModal">
        <i class="fas fa-plus me-1"></i> Thêm tài khoản mới
    </button>
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

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên tài khoản</th>
                        <th>Loại</th>
                        <th>Giá nhập</th>
                        <th>Số người dùng</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Lần cuối sử dụng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                    <tr>
                        <td>{{ $account->id }}</td>
                        <td>{{ $account->username }}</td>
                        <td>
                            @if($account->account_type == 'premium')
                                <span class="badge bg-success">Premium</span>
                            @else
                                <span class="badge bg-primary">Standard</span>
                            @endif
                        </td>
                        <td>{{ $account->cost_price ? number_format($account->cost_price, 0, ',', '.') . ' đ' : 'Chưa nhập' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $account->current_users }}/{{ $account->max_users }}</span>
                        </td>
                        <td>{{ $account->start_date ? $account->start_date->format('d/m/Y') : 'Không giới hạn' }}</td>
                        <td>{{ $account->end_date ? $account->end_date->format('d/m/Y') : 'Không giới hạn' }}</td>
                        <td>
                            @if($account->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-danger">Tạm khóa</span>
                            @endif
                        </td>
                        <td>{{ $account->last_used_at ? $account->last_used_at->format('d/m/Y H:i') : 'Chưa sử dụng' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.accounts.show', $account->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editAccountModal{{ $account->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal{{ $account->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Edit Account Modal -->
                            <div class="modal fade" id="editAccountModal{{ $account->id }}" tabindex="-1" aria-hidden="true">
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
                                                    <label for="username{{ $account->id }}" class="form-label">Tên tài khoản</label>
                                                    <input type="text" class="form-control" id="username{{ $account->id }}" name="username" value="{{ $account->username }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password{{ $account->id }}" class="form-label">Mật khẩu (để trống nếu không thay đổi)</label>
                                                    <input type="password" class="form-control" id="password{{ $account->id }}" name="password">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cost_price{{ $account->id }}" class="form-label">Giá nhập</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="cost_price{{ $account->id }}" name="cost_price" value="{{ $account->cost_price }}" min="0" step="1000">
                                                        <span class="input-group-text">VNĐ</span>
                                                    </div>
                                                    <div class="form-text">Giá nhập tài khoản để tính lợi nhuận</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="account_type{{ $account->id }}" class="form-label">Loại tài khoản</label>
                                                    <select class="form-select" id="account_type{{ $account->id }}" name="account_type" required>
                                                        <option value="standard" {{ $account->account_type == 'standard' ? 'selected' : '' }}>Standard</option>
                                                        <option value="premium" {{ $account->account_type == 'premium' ? 'selected' : '' }}>Premium</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="max_users{{ $account->id }}" class="form-label">Số người dùng tối đa</label>
                                                    <input type="number" class="form-control" id="max_users{{ $account->id }}" name="max_users" value="{{ $account->max_users }}" min="{{ $account->current_users }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description{{ $account->id }}" class="form-label">Mô tả</label>
                                                    <textarea class="form-control" id="description{{ $account->id }}" name="description" rows="3">{{ $account->description }}</textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="start_date{{ $account->id }}" class="form-label">Ngày bắt đầu</label>
                                                        <input type="date" class="form-control" id="start_date{{ $account->id }}" name="start_date" value="{{ $account->start_date ? $account->start_date->format('Y-m-d') : '' }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="end_date{{ $account->id }}" class="form-label">Ngày kết thúc</label>
                                                        <input type="date" class="form-control" id="end_date{{ $account->id }}" name="end_date" value="{{ $account->end_date ? $account->end_date->format('Y-m-d') : '' }}">
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" id="is_active{{ $account->id }}" name="is_active" {{ $account->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active{{ $account->id }}">Kích hoạt tài khoản</label>
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

                            <!-- Delete Account Modal -->
                            <div class="modal fade" id="deleteAccountModal{{ $account->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa tài khoản <strong>{{ $account->username }}</strong>?</p>
                                            <p class="text-danger">Lưu ý: Các subscription đang sử dụng tài khoản này sẽ bị gỡ liên kết.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('admin.accounts.destroy', $account->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm tài khoản mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.accounts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên tài khoản</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="cost_price" class="form-label">Giá nhập</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="cost_price" name="cost_price" min="0" step="1000">
                            <span class="input-group-text">VNĐ</span>
                        </div>
                        <div class="form-text">Giá nhập tài khoản để tính lợi nhuận</div>
                    </div>
                    <div class="mb-3">
                        <label for="account_type" class="form-label">Loại tài khoản</label>
                        <select class="form-select" id="account_type" name="account_type" required>
                            <option value="standard">Standard</option>
                            <option value="premium">Premium</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="max_users" class="form-label">Số người dùng tối đa</label>
                        <input type="number" class="form-control" id="max_users" name="max_users" value="1" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm tài khoản</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
