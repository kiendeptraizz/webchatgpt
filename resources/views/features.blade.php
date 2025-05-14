@extends('layouts.app')

@section('title', 'Tính năng - Trung Kiên Unlock')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">Khám phá dịch vụ của Trung Kiên Unlock</h1>
                <p class="hero-subtitle">Các dịch vụ AI và công nghệ cao cấp giúp bạn tối ưu hóa công việc và sáng tạo không giới hạn</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Dịch vụ nổi bật</h2>
            <p class="lead text-muted">Trải nghiệm các dịch vụ AI và công nghệ cao cấp</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-robot fa-lg"></i>
                            </div>
                            <h3 class="card-title mb-0">Mô hình AI tiên tiến</h3>
                        </div>
                        <p class="card-text">Sử dụng các mô hình AI tiên tiến nhất như GPT-4.5, Claude và nhiều mô hình khác để đảm bảo kết quả chính xác và tự nhiên nhất.</p>
                        <ul class="list-unstyled mt-3">
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Hỗ trợ đa ngôn ngữ</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Hiểu ngữ cảnh phức tạp</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Cập nhật kiến thức liên tục</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-bolt fa-lg"></i>
                            </div>
                            <h3 class="card-title mb-0">Tốc độ xử lý nhanh</h3>
                        </div>
                        <p class="card-text">Hệ thống được tối ưu hóa để xử lý hàng nghìn yêu cầu mỗi giây, đảm bảo phản hồi tức thì và không có độ trễ.</p>
                        <ul class="list-unstyled mt-3">
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Phản hồi trong thời gian thực</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Xử lý đồng thời nhiều yêu cầu</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Tối ưu hóa hiệu suất</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-lock fa-lg"></i>
                            </div>
                            <h3 class="card-title mb-0">Bảo mật tuyệt đối</h3>
                        </div>
                        <p class="card-text">Dữ liệu của bạn được bảo vệ bằng các công nghệ mã hóa tiên tiến nhất, đảm bảo an toàn và riêng tư tuyệt đối.</p>
                        <ul class="list-unstyled mt-3">
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Mã hóa đầu cuối</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Tuân thủ GDPR</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Không lưu trữ dữ liệu nhạy cảm</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-cogs fa-lg"></i>
                            </div>
                            <h3 class="card-title mb-0">Tùy chỉnh linh hoạt</h3>
                        </div>
                        <p class="card-text">Dễ dàng tùy chỉnh AI theo nhu cầu cụ thể của bạn, từ phong cách giao tiếp đến kiến thức chuyên ngành.</p>
                        <ul class="list-unstyled mt-3">
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Tạo AI theo lĩnh vực</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Điều chỉnh phong cách giao tiếp</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Huấn luyện theo dữ liệu riêng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Use Cases Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Ứng dụng thực tế</h2>
            <p class="lead text-muted">Trung Kiên Unlock cung cấp dịch vụ trong nhiều lĩnh vực khác nhau</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="https://placehold.co/600x400/4361ee/ffffff?text=Content+Creation" class="card-img-top" alt="Content Creation">
                    <div class="card-body p-4">
                        <h4 class="card-title">Sáng tạo nội dung</h4>
                        <p class="card-text">Tạo nội dung chất lượng cao cho blog, mạng xã hội, email marketing và nhiều hơn nữa.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="https://placehold.co/600x400/4361ee/ffffff?text=Customer+Support" class="card-img-top" alt="Customer Support">
                    <div class="card-body p-4">
                        <h4 class="card-title">Hỗ trợ khách hàng</h4>
                        <p class="card-text">Tự động hóa việc trả lời câu hỏi thường gặp và hỗ trợ khách hàng 24/7.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="https://placehold.co/600x400/4361ee/ffffff?text=Data+Analysis" class="card-img-top" alt="Data Analysis">
                    <div class="card-body p-4">
                        <h4 class="card-title">Phân tích dữ liệu</h4>
                        <p class="card-text">Trích xuất thông tin hữu ích từ dữ liệu lớn và tạo báo cáo chi tiết.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="https://placehold.co/600x400/4361ee/ffffff?text=Code+Assistant" class="card-img-top" alt="Code Assistant">
                    <div class="card-body p-4">
                        <h4 class="card-title">Hỗ trợ lập trình</h4>
                        <p class="card-text">Viết, debug và tối ưu hóa code trong nhiều ngôn ngữ lập trình khác nhau.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="https://placehold.co/600x400/4361ee/ffffff?text=Education" class="card-img-top" alt="Education">
                    <div class="card-body p-4">
                        <h4 class="card-title">Giáo dục</h4>
                        <p class="card-text">Hỗ trợ học tập, giải thích khái niệm phức tạp và tạo tài liệu giảng dạy.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="https://placehold.co/600x400/4361ee/ffffff?text=Research" class="card-img-top" alt="Research">
                    <div class="card-body p-4">
                        <h4 class="card-title">Nghiên cứu</h4>
                        <p class="card-text">Tổng hợp thông tin, tìm kiếm tài liệu và hỗ trợ phân tích nghiên cứu.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <h2 class="fw-bold mb-3">Sẵn sàng trải nghiệm sức mạnh của AI?</h2>
                <p class="lead mb-0">Đăng ký ngay hôm nay và nhận ưu đãi 30% cho tháng đầu tiên!</p>
            </div>
            <div class="col-lg-3 text-lg-end mt-4 mt-lg-0">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</section>
@endsection
