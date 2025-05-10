@extends('layouts.app')

@section('title', $package->name . ' - Chi tiết gói dịch vụ')

@section('content')
    <!-- Detail Header -->
    <section class="detail-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="detail-title">{{ $package->name }}</h1>
                    @if($activePromotion)
                        <div class="promotion-tag mb-3">
                            @if($activePromotion->discount_type == 'percentage')
                                <span class="promotion-badge-large"><i class="fas fa-tags me-1"></i> Giảm {{ $activePromotion->discount_value }}%</span>
                            @else
                                <span class="promotion-badge-large"><i class="fas fa-tags me-1"></i> Giảm {{ number_format($activePromotion->discount_value, 0, ',', '.') }}đ</span>
                            @endif
                        </div>
                        <div class="detail-price-container">
                            <div class="original-price">{{ number_format($package->price, 0, ',', '.') }} VNĐ</div>
                            <div class="discounted-price">{{ number_format($discountedPrice, 0, ',', '.') }} VNĐ<small>/tháng</small></div>
                        </div>
                    @else
                        <div class="detail-price">{{ number_format($package->price, 0, ',', '.') }} VNĐ<small>/tháng</small></div>
                    @endif
                    <p class="detail-description">{{ $package->description }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-5">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-7">
                <!-- Package Details -->
                <div class="detail-content">
                    <div class="mb-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách gói
                        </a>
                    </div>

                    <h3 class="mb-4">Tính năng bao gồm</h3>
                    <ul class="feature-list mb-4">
                        @php
                            $features = is_array($package->features) ? $package->features : json_decode($package->features, true);
                        @endphp
                        @foreach($features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-users text-primary me-2"></i> Số người dùng
                                    </h5>
                                    <p class="card-text fs-4">{{ $package->max_users }} người</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-clock text-primary me-2"></i> Thời hạn
                                    </h5>
                                    <p class="card-text fs-4">Linh hoạt</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="mb-3">Mô tả chi tiết</h4>
                        <p>{{ $package->description }}</p>
                        <p>Gói dịch vụ {{ $package->name }} là lựa chọn hoàn hảo cho các cá nhân và doanh nghiệp muốn tận dụng sức mạnh của trí tuệ nhân tạo trong công việc hàng ngày. Với các tính năng đa dạng và giao diện thân thiện, WebChatGPT sẽ giúp bạn tăng năng suất và hiệu quả công việc.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <!-- Subscription Form -->
                <div class="subscription-form sticky-lg-top" style="top: 100px;">
                    <h3 class="form-title mb-4">Đăng ký gói dịch vụ</h3>

                    @if (session('error'))
                        <div class="alert alert-danger mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (Auth::check())
                        <form action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $package->id }}">

                            <div class="mb-4">
                                <label for="duration" class="form-label fw-medium">Chọn thời gian thuê:</label>
                                <select name="duration" id="duration" class="form-select form-select-lg">
                                    <option value="1">1 tháng - {{ number_format($package->price, 0, ',', '.') }} VNĐ</option>
                                    <option value="3">3 tháng - {{ number_format($package->price * 3 * 0.9, 0, ',', '.') }} VNĐ (giảm 10%)</option>
                                    <option value="6">6 tháng - {{ number_format($package->price * 6 * 0.8, 0, ',', '.') }} VNĐ (giảm 20%)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium">Email liên hệ:</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg" value="{{ Auth::user()->email }}" placeholder="Nhập email của bạn" required>
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label fw-medium">Số điện thoại (Zalo):</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-comment-dots text-primary"></i></span>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại Zalo của bạn" required>
                                </div>
                                <div class="form-text">Chúng tôi sẽ liên hệ với bạn qua Zalo để hỗ trợ kích hoạt tài khoản</div>
                                @error('phone')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check-circle me-2"></i> Xác nhận đăng ký
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted">Bằng việc đăng ký, bạn đồng ý với <a href="#">điều khoản dịch vụ</a> của chúng tôi</small>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i> Vui lòng đăng nhập để đăng ký gói dịch vụ
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('login') }}?redirect={{ route('packages.show', $package->id) }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus me-2"></i> Đăng ký tài khoản mới
                            </a>
                        </div>
                    @endif

                    <hr class="my-4">

                    <div class="text-center">
                        <h5 class="mb-3">Cần hỗ trợ?</h5>
                        <div class="alert alert-info mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-comment-dots fa-2x text-primary"></i>
                                </div>
                                <div class="text-start">
                                    <strong>Tư vấn gấp?</strong> Liên hệ Zalo:
                                    <a href="https://zalo.me/0378059206" target="_blank" class="fw-bold">0378059206</a>
                                    <div class="small text-muted">Hỗ trợ nhanh chóng 24/7</div>
                                </div>
                            </div>
                        </div>
                        <p class="mb-3">Hoặc liên hệ với chúng tôi qua:</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="tel:0378059206" class="btn btn-outline-primary">
                                <i class="fas fa-phone-alt"></i>
                            </a>
                            <a href="mailto:support@webchatgpt.com" class="btn btn-outline-primary">
                                <i class="fas fa-envelope"></i>
                            </a>
                            <a href="https://m.me/webchatgpt" target="_blank" class="btn btn-outline-primary">
                                <i class="fab fa-facebook-messenger"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
