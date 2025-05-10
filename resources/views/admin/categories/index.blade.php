@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý danh mục</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus"></i> Thêm danh mục
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Loại</th>
                            <th>Danh mục cha</th>
                            <th>Icon</th>
                            <th>Thứ tự</th>
                            <th>Trạng thái</th>
                            <th>Số gói dịch vụ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if($category->isParent())
                                    <span class="badge bg-primary">Danh mục chính</span>
                                @else
                                    <span class="badge bg-info">Danh mục con</span>
                                @endif
                            </td>
                            <td>
                                @if($category->parent)
                                    {{ $category->parent->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td><i class="{{ $category->icon }}"></i> {{ $category->icon }}</td>
                            <td>{{ $category->order }}</td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Không hoạt động</span>
                                @endif
                            </td>
                            <td>{{ $category->packages->count() }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Thêm danh mục mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Danh mục cha</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="">-- Không có (Danh mục chính) --</option>
                            @foreach($categories->where('parent_id', null) as $parentCategory)
                                <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Chọn danh mục cha nếu đây là danh mục con</small>
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon (FontAwesome class)</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="fas fa-folder">
                        <small class="text-muted">Ví dụ: fas fa-folder, fas fa-star, fas fa-crown...</small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="order" class="form-label">Thứ tự hiển thị</label>
                        <input type="number" class="form-control" id="order" name="order" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modals -->
@foreach($categories as $category)
<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Chỉnh sửa danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name{{ $category->id }}" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="name{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id{{ $category->id }}" class="form-label">Danh mục cha</label>
                        <select class="form-select" id="parent_id{{ $category->id }}" name="parent_id">
                            <option value="">-- Không có (Danh mục chính) --</option>
                            @foreach($categories->where('parent_id', null)->where('id', '!=', $category->id) as $parentCategory)
                                <option value="{{ $parentCategory->id }}" {{ $category->parent_id == $parentCategory->id ? 'selected' : '' }}>
                                    {{ $parentCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Chọn danh mục cha nếu đây là danh mục con</small>
                    </div>
                    <div class="mb-3">
                        <label for="icon{{ $category->id }}" class="form-label">Icon (FontAwesome class)</label>
                        <input type="text" class="form-control" id="icon{{ $category->id }}" name="icon" value="{{ $category->icon }}" placeholder="fas fa-folder">
                        <small class="text-muted">Ví dụ: fas fa-folder, fas fa-star, fas fa-crown...</small>
                    </div>
                    <div class="mb-3">
                        <label for="description{{ $category->id }}" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description{{ $category->id }}" name="description" rows="3">{{ $category->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="order{{ $category->id }}" class="form-label">Thứ tự hiển thị</label>
                        <input type="number" class="form-control" id="order{{ $category->id }}" name="order" value="{{ $category->order }}">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active{{ $category->id }}" name="is_active" {{ $category->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active{{ $category->id }}">Hoạt động</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Delete Category Modals -->
@foreach($categories as $category)
<div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel{{ $category->id }}">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa danh mục <strong>{{ $category->name }}</strong>?</p>
                @if($category->packages->count() > 0)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Danh mục này đang có {{ $category->packages->count() }} gói dịch vụ. Nếu xóa, các gói dịch vụ sẽ không còn thuộc danh mục nào.
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
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
