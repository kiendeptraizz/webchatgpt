@extends('layouts.admin')

@section('title', 'Quản lý khuyến mãi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý khuyến mãi</h1>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm khuyến mãi
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
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
                            <th>Tên khuyến mãi</th>
                            <th>Mã</th>
                            <th>Loại giảm giá</th>
                            <th>Giá trị</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th>Sử dụng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promotions as $promotion)
                        <tr>
                            <td>{{ $promotion->id }}</td>
                            <td>{{ $promotion->name }}</td>
                            <td><code>{{ $promotion->code }}</code></td>
                            <td>
                                @if($promotion->discount_type == 'percentage')
                                    <span class="badge bg-info">Phần trăm</span>
                                @else
                                    <span class="badge bg-primary">Số tiền cố định</span>
                                @endif
                            </td>
                            <td>
                                @if($promotion->discount_type == 'percentage')
                                    {{ $promotion->discount_value }}%
                                    @if($promotion->maximum_discount)
                                        <small class="text-muted">(tối đa {{ number_format($promotion->maximum_discount, 0, ',', '.') }}đ)</small>
                                    @endif
                                @else
                                    {{ number_format($promotion->discount_value, 0, ',', '.') }}đ
                                @endif
                            </td>
                            <td>
                                <small>
                                    {{ $promotion->start_date->format('d/m/Y') }} - {{ $promotion->end_date->format('d/m/Y') }}
                                </small>
                            </td>
                            <td>
                                @if($promotion->isValid())
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    @if(!$promotion->is_active)
                                        <span class="badge bg-secondary">Không hoạt động</span>
                                    @elseif($promotion->start_date > now())
                                        <span class="badge bg-warning">Chưa bắt đầu</span>
                                    @elseif($promotion->end_date < now())
                                        <span class="badge bg-danger">Đã kết thúc</span>
                                    @elseif($promotion->usage_limit !== null && $promotion->used_count >= $promotion->usage_limit)
                                        <span class="badge bg-danger">Đã hết lượt</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($promotion->usage_limit)
                                    {{ $promotion->used_count }}/{{ $promotion->usage_limit }}
                                @else
                                    {{ $promotion->used_count }}/∞
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePromotionModal{{ $promotion->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Chưa có khuyến mãi nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Promotion Modals -->
@foreach($promotions as $promotion)
<div class="modal fade" id="deletePromotionModal{{ $promotion->id }}" tabindex="-1" aria-labelledby="deletePromotionModalLabel{{ $promotion->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePromotionModalLabel{{ $promotion->id }}">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa khuyến mãi <strong>{{ $promotion->name }}</strong>?</p>
                @if($promotion->packages->count() > 0)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Khuyến mãi này đang được áp dụng cho {{ $promotion->packages->count() }} gói dịch vụ.
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
