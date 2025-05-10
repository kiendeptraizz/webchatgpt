@extends('layouts.admin')

@section('title', 'Quản lý tin nhắn - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý tin nhắn</h1>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
                    <span class="badge bg-primary">{{ count($users) }} người dùng</span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush user-list">
                        @forelse($users as $user)
                            <a href="{{ route('admin.messages.show', $user->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        <i class="fas fa-user-circle fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                                @if($user->unread_count > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $user->unread_count }}</span>
                                @endif
                            </a>
                        @empty
                            <div class="p-4 text-center text-muted">
                                <i class="fas fa-comments fa-3x mb-3"></i>
                                <p>Chưa có cuộc trò chuyện nào.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Câu trả lời tự động</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAutoReplyModal">
                            <i class="fas fa-plus me-2"></i> Thêm câu trả lời tự động
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Từ khóa</th>
                                    <th>Phản hồi</th>
                                    <th>Độ ưu tiên</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($autoReplies as $reply)
                                    <tr>
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
                                        <td>
                                            <div class="btn-group">
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
                                        <td colspan="5" class="text-center">Chưa có câu trả lời tự động nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê tin nhắn</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Tổng tin nhắn</h6>
                                            <h2 class="mb-0">{{ \App\Models\Message::count() }}</h2>
                                        </div>
                                        <i class="fas fa-comments fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Tin nhắn đã đọc</h6>
                                            <h2 class="mb-0">{{ \App\Models\Message::where('is_read', true)->count() }}</h2>
                                        </div>
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Tin nhắn chưa đọc</h6>
                                            <h2 class="mb-0">{{ \App\Models\Message::where('is_read', false)->count() }}</h2>
                                        </div>
                                        <i class="fas fa-envelope fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<!-- Edit Auto Reply Modals -->
@foreach($autoReplies as $reply)
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
    .user-list {
        max-height: 500px;
        overflow-y: auto;
    }
    
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
