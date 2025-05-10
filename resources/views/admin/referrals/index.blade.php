@extends('layouts.admin')

@section('title', 'Quản lý giới thiệu - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Quản lý giới thiệu</h1>
        <p class="text-muted">Quản lý các giới thiệu và phần thưởng thời gian sử dụng</p>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Danh sách giới thiệu</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Người giới thiệu</th>
                        <th>Người được giới thiệu</th>
                        <th>Gói dịch vụ</th>
                        <th>Loại phần thưởng</th>
                        <th>Phần thưởng</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commissions as $commission)
                    <tr>
                        <td>{{ $commission->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-2">
                                    {{ strtoupper(substr($commission->referrer->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <span class="d-block">{{ $commission->referrer->name ?? 'Không xác định' }}</span>
                                    <small class="text-muted">{{ $commission->referrer->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-info bg-opacity-10 text-info me-2">
                                    {{ strtoupper(substr($commission->referred->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <span class="d-block">{{ $commission->referred->name ?? 'Không xác định' }}</span>
                                    <small class="text-muted">{{ $commission->referred->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $commission->subscription->package->name ?? 'Không xác định' }}</td>
                        <td>
                            @if($commission->reward_type == 'extension')
                                <span class="badge bg-success">Gia hạn thời gian</span>
                            @else
                                <span class="badge bg-secondary">Không áp dụng</span>
                            @endif
                        </td>
                        <td>
                            @if($commission->reward_type == 'extension')
                                <span class="badge bg-success">+{{ $commission->reward_days }} ngày</span>
                            @else
                                <span class="badge bg-secondary">Không áp dụng</span>
                            @endif
                        </td>
                        <td>{{ $commission->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($commission->status == 'pending')
                                <span class="badge bg-warning">Chờ xử lý</span>
                            @elseif($commission->status == 'paid')
                                <span class="badge bg-success">Đã thanh toán</span>
                                <small class="d-block text-muted">{{ $commission->paid_at ? $commission->paid_at->format('d/m/Y') : '' }}</small>
                            @else
                                <span class="badge bg-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>
                            @if($commission->status == 'pending')
                                <form action="{{ route('admin.referrals.approve', $commission->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Bạn có chắc chắn muốn phê duyệt và tặng thêm thời gian sử dụng cho người dùng này?')">
                                        <i class="fas fa-check"></i> Phê duyệt
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-sm btn-secondary" disabled>
                                    <i class="fas fa-check"></i> Đã xử lý
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    @if($commissions->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5>Chưa có dữ liệu giới thiệu</h5>
                                <p class="text-muted">Chưa có người dùng nào sử dụng mã giới thiệu để nhận thêm thời gian sử dụng.</p>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
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
