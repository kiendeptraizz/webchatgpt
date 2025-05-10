@extends('layouts.admin')

@section('title', 'Thêm khuyến mãi mới')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        min-height: 38px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #0d6efd;
        border: none;
        color: white;
        padding: 2px 8px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm khuyến mãi mới</h1>
        <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.promotions.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên khuyến mãi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="code" class="form-label">Mã khuyến mãi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
                            <small class="text-muted">Mã khuyến mãi sẽ được chuyển thành chữ hoa tự động</small>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount_type" class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
                            <select class="form-select @error('discount_type') is-invalid @enderror" id="discount_type" name="discount_type" required>
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Phần trăm (%)</option>
                                <option value="fixed_amount" {{ old('discount_type') == 'fixed_amount' ? 'selected' : '' }}>Số tiền cố định (VNĐ)</option>
                            </select>
                            @error('discount_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount_value" class="form-label">Giá trị giảm giá <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('discount_value') is-invalid @enderror" id="discount_value" name="discount_value" value="{{ old('discount_value') }}" min="0" step="0.01" required>
                            <small class="text-muted discount-type-hint">Nhập phần trăm giảm giá (ví dụ: 10 cho 10%)</small>
                            @error('discount_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="minimum_order" class="form-label">Giá trị đơn hàng tối thiểu (VNĐ)</label>
                            <input type="number" class="form-control @error('minimum_order') is-invalid @enderror" id="minimum_order" name="minimum_order" value="{{ old('minimum_order', 0) }}" min="0">
                            <small class="text-muted">Để trống hoặc 0 nếu không có giá trị tối thiểu</small>
                            @error('minimum_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="maximum_discount" class="form-label">Giảm giá tối đa (VNĐ)</label>
                            <input type="number" class="form-control @error('maximum_discount') is-invalid @enderror" id="maximum_discount" name="maximum_discount" value="{{ old('maximum_discount') }}" min="0">
                            <small class="text-muted">Chỉ áp dụng cho loại giảm giá phần trăm. Để trống nếu không giới hạn</small>
                            @error('maximum_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datepicker @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datepicker @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="usage_limit" class="form-label">Giới hạn sử dụng</label>
                            <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}" min="1">
                            <small class="text-muted">Để trống nếu không giới hạn số lần sử dụng</small>
                            @error('usage_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Kích hoạt khuyến mãi
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="packages" class="form-label">Áp dụng cho gói dịch vụ</label>
                    <select class="form-select select2 @error('packages') is-invalid @enderror" id="packages" name="packages[]" multiple>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ in_array($package->id, old('packages', [])) ? 'selected' : '' }}>
                                {{ $package->name }} ({{ number_format($package->price, 0, ',', '.') }}đ)
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Không chọn nếu muốn áp dụng cho tất cả gói dịch vụ</small>
                    @error('packages')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary me-md-2">Hủy</a>
                    <button type="submit" class="btn btn-primary">Lưu khuyến mãi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize date pickers
        flatpickr(".datepicker", {
            enableTime: false,
            dateFormat: "Y-m-d",
            locale: "vn",
            minDate: "today"
        });

        // Initialize select2
        $('.select2').select2({
            placeholder: "Chọn gói dịch vụ",
            allowClear: true
        });

        // Update discount type hint
        const discountTypeSelect = document.getElementById('discount_type');
        const discountTypeHint = document.querySelector('.discount-type-hint');

        function updateDiscountTypeHint() {
            if (discountTypeSelect.value === 'percentage') {
                discountTypeHint.textContent = 'Nhập phần trăm giảm giá (ví dụ: 10 cho 10%)';
                document.getElementById('maximum_discount').parentElement.style.display = 'block';
            } else {
                discountTypeHint.textContent = 'Nhập số tiền giảm giá (VNĐ)';
                document.getElementById('maximum_discount').parentElement.style.display = 'none';
            }
        }

        discountTypeSelect.addEventListener('change', updateDiscountTypeHint);
        updateDiscountTypeHint();
    });
</script>
@endsection
