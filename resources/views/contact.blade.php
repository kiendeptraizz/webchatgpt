@extends('layouts.app')

@section('title', 'Liên hệ - WebChatGPT')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">Liên hệ với chúng tôi</h1>
                <p class="hero-subtitle">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Tiêu đề</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Nội dung</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg">Gửi tin nhắn</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-map-marker-alt fa-lg"></i>
                        </div>
                        <h4 class="mb-3">Địa chỉ</h4>
                        <p class="mb-0">Xuân Phương, Nam Từ Liêm, Hà Nội</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-phone-alt fa-lg"></i>
                        </div>
                        <h4 class="mb-3">Điện thoại</h4>
                        <p class="mb-0">0378059206</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-envelope fa-lg"></i>
                        </div>
                        <h4 class="mb-3">Email</h4>
                        <p class="mb-0">trkien1804@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="ratio ratio-21x9">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14895.698901351693!2d105.73999!3d21.0367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454b991d80fd5%3A0x53cefc99d6b0bf6f!2zWHXDom4gUGjGsMahbmcsIE5hbSBU4burIExpw6ptLCBIw6AgTuG7mWksIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1684123456789!5m2!1svi!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Câu hỏi thường gặp</h2>
            <p class="lead text-muted">Những câu hỏi phổ biến về dịch vụ của chúng tôi</p>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Làm thế nào để bắt đầu sử dụng WebChatGPT?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Để bắt đầu sử dụng WebChatGPT, bạn chỉ cần đăng ký tài khoản, chọn gói dịch vụ phù hợp và thanh toán. Sau đó, bạn có thể truy cập vào hệ thống và bắt đầu sử dụng ngay lập tức.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                WebChatGPT có hỗ trợ tiếng Việt không?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có, WebChatGPT hỗ trợ đầy đủ tiếng Việt và nhiều ngôn ngữ khác. Hệ thống của chúng tôi được tối ưu hóa đặc biệt cho tiếng Việt để đảm bảo kết quả chính xác và tự nhiên nhất.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Tôi có thể hủy đăng ký bất cứ lúc nào không?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có, bạn có thể hủy đăng ký bất cứ lúc nào. Chúng tôi không yêu cầu cam kết dài hạn và bạn có thể hủy dịch vụ trước khi chu kỳ thanh toán tiếp theo bắt đầu.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Dữ liệu của tôi có được bảo mật không?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chúng tôi coi trọng bảo mật dữ liệu của khách hàng. Tất cả dữ liệu được mã hóa đầu cuối và chúng tôi không lưu trữ hoặc sử dụng dữ liệu của bạn cho mục đích khác ngoài việc cung cấp dịch vụ.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
