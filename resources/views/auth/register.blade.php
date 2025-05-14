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
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                </button>
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
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePasswordConfirmation">
                                    <i class="fas fa-eye" id="togglePasswordConfirmationIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
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
                            <div class="mt-2">
                                <small class="text-primary fw-bold">Nhập mã giới thiệu để nhận thêm 1 tuần sử dụng miễn phí</small>
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
                            <a href="{{ route('auth.social', 'google') }}" class="btn btn-outline-danger">
                                <i class="fab fa-google me-2"></i>Google
                            </a>
                            <a href="{{ route('auth.social', 'facebook') }}" class="btn btn-outline-primary">
                                <i class="fab fa-facebook-f me-2"></i>Facebook
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

        // Xử lý hiển thị mật khẩu
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                // Thay đổi kiểu input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Thay đổi icon
                if (type === 'text') {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            });
        }

        // Xử lý hiển thị xác nhận mật khẩu
        const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const toggleConfirmationIcon = document.getElementById('togglePasswordConfirmationIcon');

        if (togglePasswordConfirmation && passwordConfirmationInput) {
            togglePasswordConfirmation.addEventListener('click', function() {
                // Thay đổi kiểu input
                const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmationInput.setAttribute('type', type);

                // Thay đổi icon
                if (type === 'text') {
                    toggleConfirmationIcon.classList.remove('fa-eye');
                    toggleConfirmationIcon.classList.add('fa-eye-slash');
                } else {
                    toggleConfirmationIcon.classList.remove('fa-eye-slash');
                    toggleConfirmationIcon.classList.add('fa-eye');
                }
            });
        }
    });
</script>
@endsection
