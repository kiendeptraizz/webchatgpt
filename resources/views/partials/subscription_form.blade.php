<form action="{{ route('subscribe') }}" method="POST" class="subscription-form">
    @csrf
    <input type="hidden" name="package_id" value="{{ $package->id }}">

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email ?? old('email') }}" required>
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Số điện thoại Zalo <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Nhập số điện thoại Zalo của bạn">
        <small class="text-muted">Chúng tôi sẽ liên hệ qua Zalo để hỗ trợ bạn</small>
    </div>

    <div class="mb-3">
        <label for="duration" class="form-label">Thời hạn đăng ký</label>
        <select class="form-select" id="duration" name="duration" required>
            <option value="1" {{ old('duration') == '1' ? 'selected' : '' }}>1 tháng</option>
            <option value="3" {{ old('duration') == '3' ? 'selected' : '' }}>3 tháng (Giảm 10%)</option>
            <option value="6" {{ old('duration') == '6' ? 'selected' : '' }}>6 tháng (Giảm 20%)</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="promotion_code" class="form-label">Mã khuyến mãi (nếu có)</label>
        <div class="input-group">
            <input type="text" class="form-control" id="promotion_code" name="promotion_code" value="{{ old('promotion_code') }}" placeholder="Nhập mã khuyến mãi">
            <button class="btn btn-outline-secondary" type="button" id="checkPromotion">Kiểm tra</button>
        </div>
        <div id="promotionResult" class="mt-2" style="display: none;"></div>
    </div>

    <div class="mb-3">
        <label for="referral_code" class="form-label">Mã giới thiệu (nếu có)</label>
        <input type="text" class="form-control" id="referral_code" name="referral_code" value="{{ request()->get('ref') ?? old('referral_code') }}" placeholder="Nhập mã giới thiệu">
        <small class="text-muted">Người giới thiệu sẽ được cộng thêm 1 tuần sử dụng</small>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">Đăng ký ngay</button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkPromotionBtn = document.getElementById('checkPromotion');
        const promotionCodeInput = document.getElementById('promotion_code');
        const promotionResult = document.getElementById('promotionResult');
        const packageId = document.querySelector('input[name="package_id"]').value;

        if (checkPromotionBtn) {
            checkPromotionBtn.addEventListener('click', function() {
                const code = promotionCodeInput.value.trim();
                if (!code) {
                    promotionResult.innerHTML = '<div class="alert alert-warning">Vui lòng nhập mã khuyến mãi</div>';
                    promotionResult.style.display = 'block';
                    return;
                }

                // Hiển thị trạng thái đang kiểm tra
                promotionResult.innerHTML = '<div class="alert alert-info">Đang kiểm tra mã khuyến mãi...</div>';
                promotionResult.style.display = 'block';

                // Gửi AJAX request đến server để kiểm tra mã khuyến mãi
                fetch('/api/check-promotion', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        code: code,
                        package_id: packageId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mã khuyến mãi hợp lệ
                        let discountText = '';
                        if (data.promotion.discount_type === 'percentage') {
                            discountText = `${data.promotion.discount_value}%`;
                        } else {
                            discountText = new Intl.NumberFormat('vi-VN').format(data.promotion.discount_value) + 'đ';
                        }

                        let html = `<div class="alert alert-success">
                            <strong>Mã khuyến mãi hợp lệ!</strong><br>
                            Khuyến mãi: ${data.promotion.name}<br>
                            Giảm giá: ${discountText}
                        `;

                        if (data.promotion.discount_amount) {
                            const originalPrice = new Intl.NumberFormat('vi-VN').format(data.promotion.original_price);
                            const discountAmount = new Intl.NumberFormat('vi-VN').format(data.promotion.discount_amount);
                            const discountedPrice = new Intl.NumberFormat('vi-VN').format(data.promotion.discounted_price);

                            html += `<br>Giá gốc: <del>${originalPrice}đ</del><br>
                                    Số tiền giảm: <span class="text-danger">${discountAmount}đ</span><br>
                                    Giá sau khuyến mãi: <span class="text-success fw-bold">${discountedPrice}đ</span>`;
                        }

                        html += `</div>`;
                        promotionResult.innerHTML = html;
                    } else {
                        // Mã khuyến mãi không hợp lệ
                        promotionResult.innerHTML = `<div class="alert alert-danger">
                            <i class="fas fa-times-circle me-2"></i> ${data.message}
                        </div>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    promotionResult.innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra khi kiểm tra mã khuyến mãi. Vui lòng thử lại sau.</div>';
                });
            });
        }
    });
</script>
@endpush
