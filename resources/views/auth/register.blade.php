@extends('layouts.app')

@section('title', 'Đăng ký - WebChatGPT')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Tạo tài khoản mới</h2>
                        <p class="text-muted">Bắt đầu trải nghiệm sức mạnh của AI với WebChatGPT</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập họ và tên của bạn" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Tạo mật khẩu (ít nhất 8 ký tự)" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="referral_code" class="form-label">Mã giới thiệu (nếu có)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user-tag text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 @error('referral_code') is-invalid @enderror" id="referral_code" name="referral_code" value="{{ old('referral_code') }}" placeholder="Nhập mã giới thiệu (nếu có)">
                                @error('referral_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                Tôi đồng ý với <a href="#" class="text-decoration-none">Điều khoản dịch vụ</a> và <a href="#" class="text-decoration-none">Chính sách bảo mật</a>
                            </label>
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Đăng ký</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Đã có tài khoản? <a href="{{ route('login') }}" class="text-decoration-none">Đăng nhập</a></p>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-3">Hoặc đăng ký với</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-outline-secondary">
                                <i class="fab fa-google"></i>
                            </a>
                            <a href="#" class="btn btn-outline-secondary">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-secondary">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy tham số 'ref' từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const refCode = urlParams.get('ref');

        // Nếu có mã giới thiệu trong URL, điền vào trường mã giới thiệu
        if (refCode) {
            const referralCodeInput = document.getElementById('referral_code');
            if (referralCodeInput) {
                referralCodeInput.value = refCode;
            }
        }
    });
</script>
@endsection
