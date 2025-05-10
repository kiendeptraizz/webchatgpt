@extends('layouts.app')

@section('title', 'Xác nhận thanh toán - WebChatGPT')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                            </div>
                            <h2 class="card-title">Cảm ơn bạn đã thanh toán!</h2>
                            <p class="lead">Chúng tôi đã nhận được thông tin thanh toán của bạn và đang xử lý.</p>
                        </div>
                        
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
                                        <p><strong>Phương thức thanh toán:</strong> 
                                            @if($subscription->payment_method == 'bank_transfer')
                                                Chuyển khoản ngân hàng
                                            @elseif($subscription->payment_method == 'momo')
                                                Ví MoMo
                                            @elseif($subscription->payment_method == 'zalopay')
                                                ZaloPay
                                            @elseif($subscription->payment_method == 'vnpay')
                                                VNPay
                                            @else
                                                {{ $subscription->payment_method }}
                                            @endif
                                        </p>
                                        <p class="fs-5 fw-bold text-primary">
                                            <strong>Tổng tiền:</strong> {{ number_format($total_amount, 0, ',', '.') }} VNĐ
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Status -->
                        <div class="card border-warning mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-clock text-warning" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title mb-1">Trạng thái thanh toán: Đang xử lý</h5>
                                        <p class="mb-0">Chúng tôi đang xác minh thanh toán của bạn. Quá trình này có thể mất từ 1-24 giờ.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Next Steps -->
                        <div class="mb-4">
                            <h5 class="mb-3">Các bước tiếp theo</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex">
                                    <div class="me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">1</div>
                                    </div>
                                    <div>
                                        <strong>Xác minh thanh toán</strong>
                                        <p class="mb-0 text-muted">Chúng tôi sẽ xác minh thanh toán của bạn trong thời gian sớm nhất.</p>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">2</div>
                                    </div>
                                    <div>
                                        <strong>Kích hoạt tài khoản</strong>
                                        <p class="mb-0 text-muted">Sau khi xác minh thành công, gói dịch vụ của bạn sẽ được kích hoạt.</p>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">3</div>
                                    </div>
                                    <div>
                                        <strong>Thông báo qua email</strong>
                                        <p class="mb-0 text-muted">Bạn sẽ nhận được email thông báo khi gói dịch vụ được kích hoạt.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="text-center">
                            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua:</p>
                            <div class="d-flex justify-content-center gap-3 mb-4">
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fas fa-phone-alt"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fab fa-facebook-messenger"></i>
                                </a>
                            </div>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i> Quay lại trang chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
