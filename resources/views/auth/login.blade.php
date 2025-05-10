@extends('layouts.app')

@section('title', 'Đăng nhập - WebChatGPT')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Đăng nhập</h2>
                        <p class="text-muted">Chào mừng bạn quay trở lại với WebChatGPT</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <a href="#" class="text-decoration-none small">Quên mật khẩu?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Nhập mật khẩu" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Đăng nhập</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-decoration-none">Đăng ký ngay</a></p>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-3">Hoặc đăng nhập với</p>
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
