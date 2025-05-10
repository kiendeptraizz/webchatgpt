@extends('layouts.admin')

@section('title', 'Quản lý câu trả lời tự động - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý câu trả lời tự động</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAutoReplyModal">
            <i class="fas fa-plus me-2"></i> Thêm câu trả lời tự động
        </button>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách câu trả lời tự động</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Từ khóa</th>
                            <th>Phản hồi</th>
                            <th>Độ ưu tiên</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($autoReplies as $reply)
                            <tr>
                                <td>{{ $reply->id }}</td>
                                <td>{{ $reply->keyword }}</td>
                                <td>{{ Str::limit($reply->response, 50) }}</td>
                                <td>{{ $reply->priority }}</td>
                                <td>
                                    @if($reply->is_active)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Không hoạt động</span>
                                    @endif
                                </td>
                                <td>{{ $reply->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewAutoReplyModal{{ $reply->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAutoReplyModal{{ $reply->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAutoReplyModal{{ $reply->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Chưa có câu trả lời tự động nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hướng dẫn sử dụng</h6>
                </div>
                <div class="card-body">
                    <h5>Cách thức hoạt động</h5>
                    <p>Hệ thống trả lời tự động sẽ quét nội dung tin nhắn của người dùng để tìm các từ khóa đã được cài đặt. Nếu tìm thấy từ khóa phù hợp, hệ thống sẽ tự động gửi phản hồi tương ứng.</p>
                    
                    <h5>Độ ưu tiên</h5>
                    <p>Khi một tin nhắn chứa nhiều từ khóa khác nhau, hệ thống sẽ chọn câu trả lời có độ ưu tiên cao nhất để phản hồi. Độ ưu tiên càng cao (số càng lớn) thì càng được ưu tiên.</p>
                    
                    <h5>Lưu ý</h5>
                    <ul>
                        <li>Từ khóa không phân biệt chữ hoa, chữ thường.</li>
                        <li>Nên sử dụng các từ khóa đặc trưng để tránh trả lời sai.</li>
                        <li>Có thể tạm thời vô hiệu hóa một câu trả lời tự động bằng cách bỏ chọn "Kích hoạt".</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Tổng số câu trả lời</h6>
                                            <h2 class="mb-0">{{ count($autoReplies) }}</h2>
                                        </div>
                                        <i class="fas fa-reply-all fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Đang hoạt động</h6>
                                            <h2 class="mb-0">{{ $autoReplies->where('is_active', true)->count() }}</h2>
                                        </div>
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h5 class="mt-4">Từ khóa phổ biến</h5>
                    <div class="keyword-cloud">
                        @foreach($autoReplies as $reply)
                            <span class="badge {{ $reply->is_active ? 'bg-primary' : 'bg-secondary' }} p-2 m-1">{{ $reply->keyword }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Auto Reply Modal -->
<div class="modal fade" id="addAutoReplyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm câu trả lời tự động</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.auto-replies.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="keyword" class="form-label">Từ khóa</label>
                        <input type="text" class="form-control" id="keyword" name="keyword" required>
                        <div class="form-text">Tin nhắn chứa từ khóa này sẽ được trả lời tự động.</div>
                    </div>
                    <div class="mb-3">
                        <label for="response" class="form-label">Phản hồi</label>
                        <textarea class="form-control" id="response" name="response" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Độ ưu tiên</label>
                        <input type="number" class="form-control" id="priority" name="priority" min="0" value="0" required>
                        <div class="form-text">Số càng cao thì độ ưu tiên càng cao.</div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">Kích hoạt</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View, Edit, Delete Auto Reply Modals -->
@foreach($autoReplies as $reply)
    <!-- View Modal -->
    <div class="modal fade" id="viewAutoReplyModal{{ $reply->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết câu trả lời tự động</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Từ khóa</h6>
                        <p class="p-2 bg-light rounded">{{ $reply->keyword }}</p>
                    </div>
                    <div class="mb-3">
                        <h6>Phản hồi</h6>
                        <p class="p-2 bg-light rounded">{{ $reply->response }}</p>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Độ ưu tiên</h6>
                            <p>{{ $reply->priority }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Trạng thái</h6>
                            <p>
                                @if($reply->is_active)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Không hoạt động</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Ngày tạo</h6>
                            <p>{{ $reply->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Cập nhật lần cuối</h6>
                            <p>{{ $reply->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editAutoReplyModal{{ $reply->id }}">Chỉnh sửa</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div class="modal fade" id="editAutoReplyModal{{ $reply->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa câu trả lời tự động</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.auto-replies.update', $reply->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="keyword{{ $reply->id }}" class="form-label">Từ khóa</label>
                            <input type="text" class="form-control" id="keyword{{ $reply->id }}" name="keyword" value="{{ $reply->keyword }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="response{{ $reply->id }}" class="form-label">Phản hồi</label>
                            <textarea class="form-control" id="response{{ $reply->id }}" name="response" rows="4" required>{{ $reply->response }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="priority{{ $reply->id }}" class="form-label">Độ ưu tiên</label>
                            <input type="number" class="form-control" id="priority{{ $reply->id }}" name="priority" min="0" value="{{ $reply->priority }}" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active{{ $reply->id }}" name="is_active" {{ $reply->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active{{ $reply->id }}">Kích hoạt</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteAutoReplyModal{{ $reply->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa câu trả lời tự động này?</p>
                    <p><strong>Từ khóa:</strong> {{ $reply->keyword }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form action="{{ route('admin.auto-replies.destroy', $reply->id) }}" method="POST">
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

@section('styles')
<style>
    .keyword-cloud {
        margin-top: 10px;
    }
    
    .keyword-cloud .badge {
        font-size: 0.9rem;
    }
</style>
@endsection
