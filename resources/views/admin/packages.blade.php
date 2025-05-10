@extends('layouts.admin')

@section('title', 'Quản lý gói dịch vụ')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Quản lý gói dịch vụ</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPackageModal">
        <i class="fas fa-plus me-1"></i> Thêm gói dịch vụ
    </button>
</div>

<!-- Bộ lọc danh mục -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title mb-3">Lọc theo danh mục</h5>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-outline-primary category-filter active" data-category="all">
                Tất cả
            </button>
            @foreach($categories->where('parent_id', null) as $category)
                <button type="button" class="btn btn-outline-primary category-filter" data-category="{{ $category->id }}">
                    {{ $category->name }}
                </button>
                @foreach($category->children as $childCategory)
                    <button type="button" class="btn btn-outline-info category-filter" data-category="{{ $childCategory->id }}">
                        <i class="fas fa-level-down-alt me-1"></i> {{ $childCategory->name }}
                    </button>
                @endforeach
            @endforeach
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên gói</th>
                        <th>Danh mục</th>
                        <th>Giá (VNĐ)</th>
                        <th>Số người dùng tối đa</th>
                        <th>Loại</th>
                        <th>Đăng ký</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $package)
                    <tr class="package-row" data-category="{{ $package->category_id }}">
                        <td>{{ $package->id }}</td>
                        <td>{{ $package->name }}</td>
                        <td>
                            @if($package->category_id)
                                @php
                                    $category = $categories->firstWhere('id', $package->category_id);
                                    $isChild = $category && $category->parent_id;
                                    $parentName = $isChild ? $categories->firstWhere('id', $category->parent_id)->name : '';
                                @endphp

                                @if($isChild)
                                    <span class="badge bg-light text-dark">{{ $parentName }}</span>
                                    <i class="fas fa-angle-right mx-1 text-muted"></i>
                                @endif

                                <span class="badge {{ $isChild ? 'bg-info' : 'bg-primary' }}">
                                    {{ $category ? $category->name : 'Không có' }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Không có</span>
                            @endif
                        </td>
                        <td>{{ number_format($package->price, 0, ',', '.') }}</td>
                        <td>{{ $package->max_users }}</td>
                        <td>
                            @if($package->is_combo)
                                <span class="badge bg-warning">Combo</span>
                            @elseif($package->is_shared)
                                <span class="badge bg-info">Dùng chung</span>
                            @else
                                <span class="badge bg-success">Chính chủ</span>
                            @endif
                        </td>
                        <td>{{ $package->subscriptions->count() }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPackageModal{{ $package->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePackageModal{{ $package->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Edit Package Modal -->
                            <div class="modal fade" id="editPackageModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Chỉnh sửa gói dịch vụ</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Tên gói</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $package->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Mô tả</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $package->description }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Giá (VNĐ)</label>
                                                    <input type="number" class="form-control" id="price" name="price" value="{{ $package->price }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="max_users" class="form-label">Số người dùng tối đa</label>
                                                    <input type="number" class="form-control" id="max_users" name="max_users" value="{{ $package->max_users }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="category_id{{ $package->id }}" class="form-label">Danh mục</label>
                                                    <select class="form-select" id="category_id{{ $package->id }}" name="category_id">
                                                        <option value="">-- Không có danh mục --</option>
                                                        @foreach($categories->where('parent_id', null) as $parentCategory)
                                                            <optgroup label="{{ $parentCategory->name }}">
                                                                <option value="{{ $parentCategory->id }}" {{ $package->category_id == $parentCategory->id ? 'selected' : '' }}>
                                                                    {{ $parentCategory->name }} (Danh mục chính)
                                                                </option>
                                                                @foreach($parentCategory->children as $childCategory)
                                                                    <option value="{{ $childCategory->id }}" {{ $package->category_id == $childCategory->id ? 'selected' : '' }}>
                                                                        {{ $childCategory->name }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="is_shared{{ $package->id }}" name="is_shared" {{ $package->is_shared ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_shared{{ $package->id }}">Gói dùng chung</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="is_combo{{ $package->id }}" name="is_combo" {{ $package->is_combo ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_combo{{ $package->id }}">Gói combo</label>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Tính năng</label>
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="features" rows="5" placeholder="Nhập mỗi tính năng trên một dòng">{{ is_array($package->features) ? implode("\n", $package->features) : (is_string($package->features) ? implode("\n", json_decode($package->features, true) ?: []) : '') }}</textarea>
                                                        <small class="form-text text-muted">Mỗi dòng sẽ là một tính năng riêng biệt</small>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Package Modal -->
                            <div class="modal fade" id="deletePackageModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa gói dịch vụ <strong>{{ $package->name }}</strong>?</p>
                                            <p class="text-danger">Hành động này không thể hoàn tác và sẽ xóa tất cả đăng ký liên quan.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST">
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

<!-- Add Package Modal -->
<div class="modal fade" id="addPackageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm gói dịch vụ mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.packages.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên gói</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Giá (VNĐ)</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_users" class="form-label">Số người dùng tối đa</label>
                        <input type="number" class="form-control" id="max_users" name="max_users" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">-- Không có danh mục --</option>
                            @foreach($categories->where('parent_id', null) as $parentCategory)
                                <optgroup label="{{ $parentCategory->name }}">
                                    <option value="{{ $parentCategory->id }}">
                                        {{ $parentCategory->name }} (Danh mục chính)
                                    </option>
                                    @foreach($parentCategory->children as $childCategory)
                                        <option value="{{ $childCategory->id }}">
                                            {{ $childCategory->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="is_shared" name="is_shared">
                            <label class="form-check-label" for="is_shared">Gói dùng chung</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="is_combo" name="is_combo">
                            <label class="form-check-label" for="is_combo">Gói combo</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tính năng</label>
                        <div class="form-group">
                            <textarea class="form-control" name="features" rows="5" placeholder="Nhập mỗi tính năng trên một dòng">Dành cho 1 người dùng
Truy cập trên 1 thiết bị
Không giới hạn số lượng câu hỏi</textarea>
                            <small class="form-text text-muted">Mỗi dòng sẽ là một tính năng riêng biệt</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm gói</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý lọc gói dịch vụ theo danh mục
        const categoryFilters = document.querySelectorAll('.category-filter');
        const packageRows = document.querySelectorAll('.package-row');

        categoryFilters.forEach(filter => {
            filter.addEventListener('click', function() {
                // Xóa trạng thái active của tất cả các nút lọc
                categoryFilters.forEach(btn => btn.classList.remove('active'));

                // Thêm trạng thái active cho nút được nhấp
                this.classList.add('active');

                const selectedCategory = this.getAttribute('data-category');

                // Hiển thị tất cả các gói nếu chọn "Tất cả"
                if (selectedCategory === 'all') {
                    packageRows.forEach(row => {
                        row.style.display = '';
                    });
                    return;
                }

                // Lọc các gói dịch vụ theo danh mục
                packageRows.forEach(row => {
                    const rowCategory = row.getAttribute('data-category');

                    if (rowCategory === selectedCategory) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        // Tự động chọn danh mục khi thay đổi trạng thái "Gói dùng chung"
        const isSharedCheckbox = document.getElementById('is_shared');
        const categorySelect = document.getElementById('category_id');

        if (isSharedCheckbox && categorySelect) {
            isSharedCheckbox.addEventListener('change', function() {
                // Lấy danh mục đang được chọn
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                const selectedOptgroup = selectedOption.parentNode;

                // Nếu không có danh mục nào được chọn, không làm gì cả
                if (!selectedOptgroup || selectedOptgroup.tagName !== 'OPTGROUP') {
                    return;
                }

                // Lấy tên danh mục cha
                const parentCategoryName = selectedOptgroup.label;

                // Tìm danh mục con phù hợp dựa trên trạng thái checkbox
                const childOptions = selectedOptgroup.querySelectorAll('option:not(:first-child)');

                if (childOptions.length >= 2) {
                    // Giả sử tùy chọn đầu tiên là "Gói chính chủ" và tùy chọn thứ hai là "Gói dùng chung"
                    if (this.checked) {
                        // Nếu checkbox được chọn, chọn "Gói dùng chung"
                        childOptions[1].selected = true;
                    } else {
                        // Nếu checkbox không được chọn, chọn "Gói chính chủ"
                        childOptions[0].selected = true;
                    }
                }
            });
        }
    });
</script>
@endsection
