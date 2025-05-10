@extends('layouts.app')

@section('title', 'Thanh toán - WebChatGPT')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Thanh toán đơn hàng</h2>

                        <!-- Alert Messages -->
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

                        <!-- Order Summary -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Thông tin đơn hàng</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Gói dịch vụ:</strong> {{ $subscription->package->name }}</p>
                                        <p><strong>Thời hạn:</strong> {{ $duration }} tháng</p>
                                        <p><strong>Ngày bắt đầu:</strong> {{ $subscription->start_date->format('d/m/Y') }}</p>
                                        <p><strong>Ngày kết thúc:</strong> {{ $subscription->end_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Mã đơn hàng:</strong> #{{ $subscription->id }}</p>
                                        <p><strong>Ngày đặt:</strong> {{ $subscription->created_at->format('d/m/Y H:i') }}</p>
                                        <p><strong>Email:</strong> {{ $email }}</p>
                                        <p><strong>Số điện thoại (Zalo):</strong> {{ $phone }}</p>

                                        @if(isset($promotion) && $promotion)
                                        <div class="price-details mt-2">
                                            <p><strong>Giá gốc:</strong> <span class="text-decoration-line-through">{{ number_format($originalPrice, 0, ',', '.') }} VNĐ</span></p>
                                            <p>
                                                <strong>Khuyến mãi:</strong>
                                                <span class="badge bg-danger">{{ $promotion->name }}</span>
                                                <span class="text-danger">
                                                    @if($promotion->discount_type == 'percentage')
                                                        -{{ $promotion->discount_value }}%
                                                    @else
                                                        -{{ number_format($promotion->discount_value, 0, ',', '.') }} VNĐ
                                                    @endif
                                                </span>
                                            </p>
                                            <p><strong>Giảm giá:</strong> <span class="text-danger">-{{ number_format($discountAmount, 0, ',', '.') }} VNĐ</span></p>
                                        </div>
                                        @endif

                                        <p class="fs-5 fw-bold text-primary mt-2">
                                            <strong>Tổng tiền:</strong> {{ number_format($total_amount, 0, ',', '.') }} VNĐ
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Methods -->
                        <form action="{{ route('payment.process', $subscription->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h5 class="mb-3">Chọn phương thức thanh toán</h5>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check payment-method-card">
                                        <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" checked>
                                        <label class="form-check-label d-flex align-items-center" for="bank_transfer">
                                            <img src="https://cdn-icons-png.flaticon.com/512/2168/2168742.png" alt="Bank Transfer" width="40" class="me-2">
                                            <div>
                                                <span class="d-block fw-medium">Chuyển khoản ngân hàng</span>
                                                <small class="text-muted">Chuyển khoản qua tài khoản ngân hàng</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check payment-method-card">
                                        <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo">
                                        <label class="form-check-label d-flex align-items-center" for="momo">
                                            <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="MoMo" width="40" class="me-2">
                                            <div>
                                                <span class="d-block fw-medium">Ví MoMo</span>
                                                <small class="text-muted">Thanh toán qua ví điện tử MoMo</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>


                            </div>

                            <!-- Payment Instructions -->
                            <div class="payment-instructions mb-4">
                                <div class="bank-transfer-instructions">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0">Thông tin chuyển khoản</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                                    <div class="qr-code-wrapper">
                                                        <img src="{{ asset('images/tpbank.jpg') }}" alt="TPBank QR Code" class="img-fluid qr-code-image">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="payment-info">
                                                        <p class="payment-info-item"><strong>Ngân hàng:</strong> TPBank</p>
                                                        <p class="payment-info-item"><strong>Số tài khoản:</strong> 6571 8042 005</p>
                                                        <p class="payment-info-item"><strong>Chủ tài khoản:</strong> DO TRUNG KIEN</p>
                                                        <p class="payment-info-item"><strong>Số tiền:</strong> {{ number_format($total_amount, 0, ',', '.') }} VNĐ</p>
                                                        <p class="payment-info-item"><strong>Nội dung chuyển khoản:</strong> <span class="text-danger fw-bold">WCG{{ $subscription->id }}</span></p>
                                                    </div>
                                                    <div class="alert alert-info mt-3">
                                                        <i class="fas fa-info-circle me-2"></i> Vui lòng chuyển khoản đúng số tiền và nội dung để chúng tôi có thể xác nhận thanh toán của bạn nhanh chóng.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="momo-instructions d-none">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0">Thông tin thanh toán MoMo</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                                    <div class="qr-code-wrapper">
                                                        <img src="{{ asset('images/momo.jpg') }}" alt="MoMo QR Code" class="img-fluid qr-code-image">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="payment-info">
                                                        <p class="payment-info-item"><strong>Số điện thoại:</strong> 0378059206</p>
                                                        <p class="payment-info-item"><strong>Tên tài khoản:</strong> DO TRUNG KIEN</p>
                                                        <p class="payment-info-item"><strong>Số tiền:</strong> {{ number_format($total_amount, 0, ',', '.') }} VNĐ</p>
                                                        <p class="payment-info-item"><strong>Nội dung chuyển khoản:</strong> <span class="text-danger fw-bold">WCG{{ $subscription->id }}</span></p>
                                                    </div>
                                                    <div class="alert alert-info mt-3">
                                                        <i class="fas fa-info-circle me-2"></i> Vui lòng chuyển đúng số tiền và nội dung để chúng tôi có thể xác nhận thanh toán của bạn nhanh chóng.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <!-- Upload Payment Proof -->
                            <div class="mb-4">
                                <h5 class="mb-3">Tải lên bằng chứng thanh toán</h5>
                                <div class="mb-3">
                                    <label for="payment_proof" class="form-label">Hình ảnh bằng chứng thanh toán</label>
                                    <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/*" required>
                                    <div class="form-text">Hỗ trợ các định dạng: JPG, PNG, GIF. Kích thước tối đa: 5MB</div>
                                    @error('payment_proof')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="referral_code" class="form-label">Mã giới thiệu (nếu có)</label>
                                    <input type="text" class="form-control" id="referral_code" name="referral_code" placeholder="Nhập mã giới thiệu nếu bạn được giới thiệu bởi người khác">
                                    <div class="form-text">Người giới thiệu sẽ nhận được hoa hồng khi bạn đăng ký thành công</div>
                                </div>
                                <div class="mb-3">
                                    <label for="payment_notes" class="form-label">Ghi chú (tùy chọn)</label>
                                    <textarea class="form-control" id="payment_notes" name="payment_notes" rows="3" placeholder="Nhập ghi chú về thanh toán của bạn (nếu có)"></textarea>
                                </div>
                            </div>

                            <div class="alert alert-info mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="col-md-4 text-center mb-3 mb-md-0">
                                        <div class="qr-code-wrapper">
                                            <img src="{{ asset('images/zalo.jpg') }}" alt="Zalo QR Code" class="img-fluid qr-code-image" style="max-width: 120px;">
                                            <div class="mt-2 text-center">
                                                <strong>Quét mã để liên hệ</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div>
                                            <strong>Cần hỗ trợ thanh toán?</strong> Liên hệ Zalo:
                                            <a href="https://zalo.me/0378059206" target="_blank" class="fw-bold">0378059206</a>
                                            <div class="small text-muted">Hỗ trợ nhanh chóng 24/7</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check-circle me-2"></i> Xác nhận thanh toán
                                </button>
                                <a href="{{ route('packages.show', $subscription->package_id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const instructionDivs = {
            'bank_transfer': document.querySelector('.bank-transfer-instructions'),
            'momo': document.querySelector('.momo-instructions')
        };

        function showInstructions(method) {
            // Hide all instruction divs
            Object.values(instructionDivs).forEach(div => {
                div.classList.add('d-none');
            });

            // Show the selected method's instructions
            if (instructionDivs[method]) {
                instructionDivs[method].classList.remove('d-none');
            }
        }

        // Initial setup
        const checkedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (checkedMethod) {
            showInstructions(checkedMethod.value);
        }

        // Add event listeners to radio buttons
        paymentMethods.forEach(radio => {
            radio.addEventListener('change', function() {
                showInstructions(this.value);
            });
        });
    });
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/payment-proof.css') }}">
<style>
    .form-check-input {
        margin-top: 1.2rem;
    }

    .qr-code-wrapper {
        position: relative;
        display: inline-block;
    }

    .qr-code-wrapper::after {
        content: "Quét mã QR để thanh toán";
        position: absolute;
        bottom: -25px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 12px;
        color: #6c757d;
    }

    .payment-instructions .card-body {
        padding: 1.5rem;
    }

    .payment-info-item {
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px dashed #e9ecef;
    }

    .payment-info-item:last-child {
        border-bottom: none;
    }
</style>
@endsection
