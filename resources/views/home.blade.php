@extends('layouts.app')

@section('title', 'Trung Kiên Unlock - Đồng hành cùng bạn, mở lối công nghệ')

@section('content')
    <!-- Service Info Modal -->
    <div class="modal fade" id="serviceInfoModal" tabindex="-1" aria-labelledby="serviceInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceInfoModalLabel">Thông tin dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="serviceContent">
                        <!-- Nội dung sẽ được thêm bằng JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <a href="#" id="serviceDetailLink" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section -->
    <section class="hero-section tech-bg">
        <div class="tech-particles"></div>
        <div class="tech-grid"></div>
        <div class="tech-lines"></div>

        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content position-relative">
                        <!-- Tech decorative elements -->
                        <div class="tech-circle"></div>
                        <div class="tech-dots"></div>

                        <h1 class="hero-title mb-4">
                            <span class="d-block mb-2">Mở khóa tiềm năng</span>
                            <span class="gradient-text">Công nghệ AI</span>
                            <span class="typing-text">Cao cấp</span>
                        </h1>

                        <p class="hero-subtitle mb-4">Trung Kiên Unlock cung cấp các dịch vụ AI và công nghệ cao cấp với giá tốt nhất thị trường, giúp bạn tối ưu hóa công việc và sáng tạo không giới hạn.</p>

                        <div class="search-box mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="fas fa-search text-light"></i>
                                </span>
                                <input type="text" class="form-control form-control-lg bg-transparent text-light border-0 shadow-none" placeholder="Tìm kiếm dịch vụ..." id="searchPackage" autocomplete="off">
                                <button class="btn btn-glow tech-btn" type="button" id="searchButton">
                                    <i class="fas fa-search me-1"></i> Tìm kiếm
                                </button>
                            </div>
                            <div class="search-border"></div>
                            <div class="search-results-info text-light mt-2" id="searchResultsInfo" style="display: none;">
                                <small><i class="fas fa-info-circle me-1"></i> <span id="searchResultsCount"></span></small>
                                <a href="#" id="clearSearch" class="text-light ms-2" style="text-decoration: none; font-size: 0.9rem;">
                                    <i class="fas fa-times-circle"></i> Xóa
                                </a>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            <a href="#packages" class="btn btn-primary btn-lg tech-btn btn-glow">
                                <i class="fas fa-list-ul me-2"></i> Xem các gói dịch vụ
                            </a>
                            <a href="https://zalo.me/0378059206" target="_blank" class="btn btn-outline-light btn-lg tech-btn">
                                <i class="fas fa-headset me-2"></i> Tư vấn ngay
                            </a>
                        </div>

                        <!-- Tech badges -->
                        <div class="tech-badges mt-4">
                            <div class="badge-container">
                                <span class="badge-tech service-badge" data-service="ChatGPT">
                                    <i class="fas fa-robot me-2"></i>ChatGPT 4.5
                                </span>
                            </div>
                            <div class="badge-container">
                                <span class="badge-tech service-badge" data-service="Canva">
                                    <i class="fas fa-palette me-2"></i>Canva Pro
                                </span>
                            </div>
                            <div class="badge-container">
                                <span class="badge-tech service-badge" data-service="YouTube">
                                    <i class="fab fa-youtube me-2"></i>YouTube Premium
                                </span>
                            </div>
                            <div class="badge-container">
                                <span class="badge-tech service-badge" data-service="Spotify">
                                    <i class="fab fa-spotify me-2"></i>Spotify
                                </span>
                            </div>
                            <div class="badge-container">
                                <span class="badge-tech service-badge" data-service="CapCut">
                                    <i class="fas fa-video me-2"></i>CapCut Pro
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-container position-relative d-none d-lg-block">
                        <!-- Floating elements -->
                        <div class="floating-icon icon-lg" style="top: 5%; left: 10%;">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="floating-icon icon-md" style="top: 15%; right: 15%;">
                            <i class="fas fa-brain"></i>
                        </div>
                        <div class="floating-icon icon-sm" style="bottom: 20%; left: 15%;">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="floating-icon icon-xs" style="bottom: 30%; right: 25%;">
                            <i class="fas fa-microchip"></i>
                        </div>

                        <!-- Tech circles -->
                        <div class="tech-circle-1"></div>
                        <div class="tech-circle-2"></div>

                        <!-- Main image with tech frame -->
                        <div class="tech-frame">
                            <div class="frame-corner top-left"></div>
                            <div class="frame-corner top-right"></div>
                            <div class="frame-corner bottom-left"></div>
                            <div class="frame-corner bottom-right"></div>
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Trung Kiên Unlock AI Services" class="img-fluid rounded tech-glow">
                        </div>

                        <!-- Tech overlay -->
                        <div class="tech-overlay"></div>
                    </div>

                    <!-- Mobile hero image (only visible on mobile) -->
                    <div class="d-block d-lg-none text-center mt-4">
                        <div class="tech-frame-mobile mx-auto" style="max-width: 200px; position: relative;">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Trung Kiên Unlock AI Services" class="img-fluid rounded tech-glow">
                            <div class="tech-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats Section -->
    <section class="py-4 bg-light tech-stats">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-3 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-icon mb-2">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <h3 class="stat-number mb-0">1000+</h3>
                        <p class="stat-text mb-0">Khách hàng</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-icon mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <h3 class="stat-number mb-0">99%</h3>
                        <p class="stat-text mb-0">Độ hài lòng</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-icon mb-2">
                            <i class="fas fa-award text-warning"></i>
                        </div>
                        <h3 class="stat-number mb-0">5+</h3>
                        <p class="stat-text mb-0">Năm kinh nghiệm</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-icon mb-2">
                            <i class="fas fa-tools text-danger"></i>
                        </div>
                        <h3 class="stat-number mb-0">10+</h3>
                        <p class="stat-text mb-0">Dịch vụ</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section class="py-5" id="packages">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-title-wrapper">
                    <h2 class="fw-bold mb-3 section-title">DỊCH VỤ PREMIUM CHẤT LƯỢNG CAO</h2>
                    <div class="section-title-decoration"></div>
                </div>
                <p class="lead text-muted">Lựa chọn gói dịch vụ phù hợp với nhu cầu của bạn</p>
            </div>

            <!-- Hiển thị các gói dịch vụ theo danh mục -->
            @foreach($categories->where('parent_id', null) as $category)
                @if($category->packages->count() > 0 || $category->children->count() > 0)
                <div class="mb-5">
                    <div class="category-header">
                        <div class="category-icon">
                            <i class="{{ $category->icon ?: 'fas fa-folder' }}"></i>
                        </div>
                        <div class="category-title">
                            <h3 class="fw-bold mb-2">{{ $category->name }}</h3>
                            <div class="category-line"></div>
                        </div>
                    </div>
                    <p class="lead mb-4">{{ $category->description }}</p>

                    <!-- Hiển thị các danh mục con -->
                    @if($category->children->count() > 0)
                        @foreach($category->children as $childCategory)
                            @if($childCategory->packages->count() > 0)
                                <div class="subcategory-header mt-4">
                                    <div class="subcategory-icon">
                                        <i class="{{ $childCategory->icon ?: 'fas fa-folder-open' }}"></i>
                                    </div>
                                    <h4 class="fw-bold mb-3">{{ $childCategory->name }}</h4>
                                </div>
                                <p class="mb-4">{{ $childCategory->description }}</p>

                                <!-- Hiển thị các gói dịch vụ của danh mục con -->
                                <div class="row">
                                    @foreach($childCategory->packages as $package)
                                        <div class="col-lg-6 mb-4">
                                            <div class="package-card" data-package-id="{{ $package->id }}">
                                                @if($package->name == 'ChatGPT Plus')
                                                    <div class="package-badge">
                                                        <i class="fas fa-star me-1"></i> Phổ biến nhất
                                                    </div>
                                                @endif
                                                @if($package->name == 'Canva Pro')
                                                    <div class="package-badge" style="background: #7209b7;">
                                                        <i class="fas fa-crown me-1"></i> Bán chạy
                                                    </div>
                                                @endif
                                                <div class="package-header">
                                                    <h3 class="package-title">{{ $package->name }}</h3>
                                                    <div class="package-price-container">
                                                        @include('partials.promotion_badge', ['package' => $package, 'childCategory' => $childCategory])
                                                        @if($childCategory->name == 'GIẢI TRÍ & ĐA PHƯƠNG TIỆN')
                                                            <small>/năm</small>
                                                        @elseif(strpos(strtolower($package->name), 'tháng') !== false || $package->price == 380000)
                                                            <small>/tháng</small>
                                                        @elseif(strpos(strtolower($package->name), 'năm') !== false || $package->price == 150000)
                                                            <small>/năm</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="package-body">
                                                    <ul class="feature-list">
                                                        @php
                                                            $features = is_array($package->features) ? $package->features : json_decode($package->features, true);
                                                        @endphp
                                                        @foreach($features as $feature)
                                                            <li>{{ $feature }}</li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="d-grid">
                                                        <a href="{{ route('packages.show', $package->id) }}" class="btn btn-primary">Xem chi tiết</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endif

                    <!-- Hiển thị các gói dịch vụ của danh mục chính (nếu có) -->
                    @if($category->packages->count() > 0)
                    <div class="row">
                        @foreach($category->packages as $package)
                            <div class="col-lg-6 mb-4">
                                <div class="package-card" data-package-id="{{ $package->id }}">
                                    @if($package->name == 'ChatGPT Plus')
                                        <div class="package-badge">
                                            <i class="fas fa-star me-1"></i> Phổ biến nhất
                                        </div>
                                    @endif
                                    @if($package->name == 'Canva Pro')
                                        <div class="package-badge" style="background: #7209b7;">
                                            <i class="fas fa-crown me-1"></i> Bán chạy
                                        </div>
                                    @endif
                                    <div class="package-header">
                                        <h3 class="package-title">{{ $package->name }}</h3>
                                        <div class="package-price-container">
                                            @include('partials.promotion_badge', ['package' => $package, 'category' => $category])
                                            @if($category->name == 'GIẢI TRÍ & ĐA PHƯƠNG TIỆN')
                                                <small>/năm</small>
                                            @elseif(strpos(strtolower($package->name), 'tháng') !== false || $package->price == 380000)
                                                <small>/tháng</small>
                                            @elseif(strpos(strtolower($package->name), 'năm') !== false || $package->price == 150000)
                                                <small>/năm</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="package-body">
                                        <ul class="feature-list">
                                            @php
                                                $features = is_array($package->features) ? $package->features : json_decode($package->features, true);
                                            @endphp
                                            @foreach($features as $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>

                                        <div class="d-grid">
                                            <a href="{{ route('packages.show', $package->id) }}" class="btn btn-primary">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif
            @endforeach

            <!-- Giữ lại các phần cũ để tránh lỗi trong quá trình chuyển đổi -->
            <div style="display: none;">
                @foreach($aiCreativePersonal as $package)
                @endforeach
                @foreach($aiCreativeShared as $package)
                @endforeach
                @foreach($entertainment as $package)
                @endforeach
            </div>

            <!-- COMBO TIẾT KIỆM -->
            <div class="mb-5">
                <div class="category-header">
                    <div class="category-icon bg-success">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="category-title">
                        <h3 class="fw-bold mb-2">COMBO TIẾT KIỆM</h3>
                        <div class="category-line"></div>
                    </div>
                </div>
                <p class="lead mb-4">Tiết kiệm hơn với các gói combo đặc biệt</p>

                <div class="row">
                    @foreach($combos as $package)
                        <div class="col-lg-4 mb-4">
                            <div class="package-card">
                                <div class="package-header">
                                    <h3 class="package-title">{{ $package->name }}</h3>
                                    <div class="package-price-container">
                                        @include('partials.promotion_badge', ['package' => $package])
                                        @if(strpos(strtolower($package->name), 'tháng') !== false)
                                            <small>/tháng</small>
                                        @elseif(strpos(strtolower($package->name), 'năm') !== false)
                                            <small>/năm</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="package-body">
                                    <p>{{ $package->description }}</p>
                                    <ul class="feature-list">
                                        @php
                                            $features = is_array($package->features) ? $package->features : json_decode($package->features, true);
                                        @endphp
                                        @foreach($features as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>

                                    <div class="d-grid">
                                        <a href="{{ route('packages.show', $package->id) }}" class="btn btn-primary">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- CHƯƠNG TRÌNH KHUYẾN MÃI -->
            <div class="mb-5">
                <div class="category-header">
                    <div class="category-icon bg-danger">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="category-title">
                        <h3 class="fw-bold mb-2">CHƯƠNG TRÌNH KHUYẾN MÃI</h3>
                        <div class="category-line"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <span class="badge bg-primary rounded-pill me-3">🎁</span>
                                        <span>Giảm 10% khi đăng ký 3 tháng</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <span class="badge bg-primary rounded-pill me-3">🎁</span>
                                        <span>Giảm 15% khi đăng ký 6 tháng</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <span class="badge bg-primary rounded-pill me-3">🎁</span>
                                        <span>Giảm 20% khi đăng ký 12 tháng</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <span class="badge bg-primary rounded-pill me-3">🎁</span>
                                        <span>Tặng thêm 1 tuần khi giới thiệu bạn bè</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SO SÁNH CÁC GÓI CHATGPT -->
            <div class="mb-5">
                <div class="category-header">
                    <div class="category-icon bg-info">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="category-title">
                        <h3 class="fw-bold mb-2">SO SÁNH CÁC GÓI CHATGPT</h3>
                        <div class="category-line"></div>
                    </div>
                </div>
                <!-- Comparison table for desktop -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-bordered table-hover comparison-table">
                        <thead>
                            <tr class="text-center">
                                <th class="feature-column">Tính năng</th>
                                <th class="text-primary">
                                    <div class="plan-title">ChatGPT Plus</div>
                                    <div class="plan-badge">Chính chủ</div>
                                </th>
                                <th class="text-success">
                                    <div class="plan-title">ChatGPT Cơ bản</div>
                                    <div class="plan-badge bg-success">Tiết kiệm</div>
                                </th>
                                <th class="text-info">
                                    <div class="plan-title">ChatGPT Nâng cao</div>
                                    <div class="plan-badge bg-info">Phổ biến</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="price-row text-center">
                                <td class="feature-name">Giá</td>
                                <td class="highlight-primary">
                                    <div class="price-value">380K</div>
                                    <div class="price-period">/tháng</div>
                                </td>
                                <td class="highlight-success">
                                    <div class="price-value">69K</div>
                                    <div class="price-period">/tháng</div>
                                </td>
                                <td class="highlight-info">
                                    <div class="price-value">139K</div>
                                    <div class="price-period">/tháng</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="feature-name">Số người dùng</td>
                                <td class="text-center">1 (chính chủ)</td>
                                <td class="text-center feature-highlight">6 người</td>
                                <td class="text-center">3 người</td>
                            </tr>
                            <tr>
                                <td class="feature-name">Số thiết bị</td>
                                <td class="text-center feature-highlight">Không giới hạn</td>
                                <td class="text-center">1 thiết bị</td>
                                <td class="text-center">2 thiết bị</td>
                            </tr>
                            <tr>
                                <td class="feature-name">Mô hình AI</td>
                                <td class="text-center feature-highlight">GPT-4.5</td>
                                <td class="text-center">GPT-3.5</td>
                                <td class="text-center feature-highlight">GPT-4.5</td>
                            </tr>
                            <tr>
                                <td class="feature-name">Tải tệp</td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td class="feature-name">Truy cập tính năng mới</td>
                                <td class="text-center feature-highlight">Sớm nhất</td>
                                <td class="text-center">Giới hạn</td>
                                <td class="text-center">Đầy đủ</td>
                            </tr>
                            <tr>
                                <td class="feature-name">Hỗ trợ kỹ thuật</td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td class="feature-name"></td>
                                <td class="text-center">
                                    <a href="{{ route('packages.show', 1) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('packages.show', 6) }}" class="btn btn-success btn-sm">Xem chi tiết</a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('packages.show', 7) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile comparison cards (only visible on mobile) -->
                <div class="d-block d-md-none">
                    <div class="row">
                        <!-- ChatGPT Plus Card -->
                        <div class="col-12 mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white text-center">
                                    <h5 class="mb-0">ChatGPT Plus</h5>
                                    <span class="badge bg-light text-primary">Chính chủ</span>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h3 class="text-primary mb-0">380K</h3>
                                        <small class="text-muted">/tháng</small>
                                    </div>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Số người dùng
                                            <span>1 (chính chủ)</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Số thiết bị
                                            <span class="fw-bold text-primary">Không giới hạn</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Mô hình AI
                                            <span class="fw-bold text-primary">GPT-4.5</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tải tệp
                                            <i class="fas fa-check text-success"></i>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Truy cập tính năng mới
                                            <span class="fw-bold text-primary">Sớm nhất</span>
                                        </li>
                                    </ul>
                                    <div class="d-grid">
                                        <a href="{{ route('packages.show', 1) }}" class="btn btn-primary">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ChatGPT Cơ bản Card -->
                        <div class="col-12 mb-4">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white text-center">
                                    <h5 class="mb-0">ChatGPT Cơ bản</h5>
                                    <span class="badge bg-light text-success">Tiết kiệm</span>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h3 class="text-success mb-0">69K</h3>
                                        <small class="text-muted">/tháng</small>
                                    </div>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Số người dùng
                                            <span class="fw-bold text-success">6 người</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Số thiết bị
                                            <span>1 thiết bị</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Mô hình AI
                                            <span>GPT-3.5</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tải tệp
                                            <i class="fas fa-check text-success"></i>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Truy cập tính năng mới
                                            <span>Giới hạn</span>
                                        </li>
                                    </ul>
                                    <div class="d-grid">
                                        <a href="{{ route('packages.show', 6) }}" class="btn btn-success">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ChatGPT Nâng cao Card -->
                        <div class="col-12 mb-4">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white text-center">
                                    <h5 class="mb-0">ChatGPT Nâng cao</h5>
                                    <span class="badge bg-light text-info">Phổ biến</span>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h3 class="text-info mb-0">139K</h3>
                                        <small class="text-muted">/tháng</small>
                                    </div>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Số người dùng
                                            <span>3 người</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Số thiết bị
                                            <span>2 thiết bị</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Mô hình AI
                                            <span class="fw-bold text-info">GPT-4.5</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tải tệp
                                            <i class="fas fa-check text-success"></i>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Truy cập tính năng mới
                                            <span>Đầy đủ</span>
                                        </li>
                                    </ul>
                                    <div class="d-grid">
                                        <a href="{{ route('packages.show', 7) }}" class="btn btn-info">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Tại sao chọn Trung Kiên Unlock?</h2>
                <p class="lead text-muted">Chúng tôi cung cấp giải pháp công nghệ cao cấp với giá tốt nhất thị trường</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-robot fa-2x"></i>
                            </div>
                            <h4 class="card-title mb-3">Công nghệ tiên tiến</h4>
                            <p class="card-text">Sử dụng các mô hình AI tiên tiến nhất, bao gồm GPT-4.5 và nhiều mô hình khác.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-lock fa-2x"></i>
                            </div>
                            <h4 class="card-title mb-3">Bảo mật tuyệt đối</h4>
                            <p class="card-text">Dữ liệu của bạn được bảo vệ an toàn với các tiêu chuẩn bảo mật cao nhất.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-headset fa-2x"></i>
                            </div>
                            <h4 class="card-title mb-3">Hỗ trợ 24/7</h4>
                            <p class="card-text">Đội ngũ hỗ trợ chuyên nghiệp luôn sẵn sàng giúp đỡ bạn mọi lúc mọi nơi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Khách hàng nói gì về chúng tôi</h2>
                <p class="lead text-muted">Hàng ngàn khách hàng đã tin tưởng và sử dụng dịch vụ của Trung Kiên Unlock</p>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text mb-4">"Trung Kiên Unlock đã giúp công ty chúng tôi tăng năng suất làm việc lên 40%. Các dịch vụ AI thực sự ấn tượng và dễ sử dụng."</p>
                            <div class="d-flex align-items-center">
                                <img src="https://placehold.co/50x50" alt="Avatar" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Nguyễn Văn A</h6>
                                    <small class="text-muted">CEO, Công ty ABC</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text mb-4">"Tôi đã thử nhiều dịch vụ khác nhau, nhưng Trung Kiên Unlock thực sự vượt trội. Dịch vụ chuyên nghiệp, giá cả hợp lý và hỗ trợ khách hàng tận tình."</p>
                            <div class="d-flex align-items-center">
                                <img src="https://placehold.co/50x50" alt="Avatar" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Trần Thị B</h6>
                                    <small class="text-muted">Nhà văn</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text mb-4">"Dịch vụ khách hàng tuyệt vời! Mỗi khi tôi gặp vấn đề, đội ngũ hỗ trợ luôn sẵn sàng giúp đỡ. Tôi rất hài lòng với Trung Kiên Unlock và sẽ tiếp tục sử dụng lâu dài."</p>
                            <div class="d-flex align-items-center">
                                <img src="https://placehold.co/50x50" alt="Avatar" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Lê Văn C</h6>
                                    <small class="text-muted">Giáo viên</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Urgent Consultation Section -->
    <section class="py-4 bg-warning">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 col-md-8">
                    <h3 class="fw-bold mb-2">Tư vấn khẩn cấp?</h3>
                    <p class="lead mb-0">Liên hệ ngay qua Zalo: <strong>0378059206</strong> để được hỗ trợ nhanh chóng!</p>
                </div>
                <div class="col-lg-3 col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="https://zalo.me/0378059206" target="_blank" class="btn btn-dark">
                        <i class="fas fa-comment-dots me-2"></i> Chat Zalo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 col-md-8">
                    <h2 class="fw-bold mb-3">Sẵn sàng trải nghiệm sức mạnh của AI?</h2>
                    <p class="lead mb-0">Đăng ký ngay hôm nay và nhận ưu đãi 30% cho tháng đầu tiên!</p>
                </div>
                <div class="col-lg-3 col-md-4 text-md-end mt-4 mt-md-0">
                    <a href="#packages" class="btn btn-light">Đăng ký ngay</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light" id="faq">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-title-wrapper">
                    <h2 class="fw-bold mb-3 section-title">CÂU HỎI THƯỜNG GẶP</h2>
                    <div class="section-title-decoration"></div>
                </div>
                <p class="lead text-muted">Những câu hỏi phổ biến về dịch vụ của chúng tôi</p>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Tôi có thể nâng cấp hoặc hạ cấp gói dịch vụ không?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Có, bạn có thể dễ dàng nâng cấp hoặc hạ cấp gói dịch vụ bất kỳ lúc nào. Khi nâng cấp, bạn sẽ được tính phí theo tỷ lệ cho thời gian còn lại của gói hiện tại.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Làm thế nào để thanh toán?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Chúng tôi chấp nhận thanh toán qua MoMo và chuyển khoản ngân hàng. Sau khi đăng ký gói dịch vụ, bạn sẽ nhận được thông tin thanh toán chi tiết qua email và tin nhắn.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Có được dùng thử trước khi mua không?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Có, bạn có thể liên hệ với chúng tôi qua Zalo để được hỗ trợ dùng thử một số dịch vụ trong thời gian ngắn. Chúng tôi muốn bạn hoàn toàn hài lòng trước khi quyết định mua.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Tôi có thể sử dụng tài khoản trên bao nhiêu thiết bị?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Điều này phụ thuộc vào gói dịch vụ bạn đăng ký. Các gói chính chủ thường cho phép sử dụng trên nhiều thiết bị, trong khi các gói dùng chung có thể có giới hạn về số thiết bị. Chi tiết cụ thể được liệt kê trong mô tả của từng gói.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    Làm thế nào để nhận hỗ trợ kỹ thuật?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bạn có thể liên hệ với chúng tôi qua Zalo: 0378059206 hoặc sử dụng tính năng chat trên trang web. Đội ngũ hỗ trợ của chúng tôi sẵn sàng giúp đỡ bạn 24/7.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Thêm class has-promotion cho các gói dịch vụ có khuyến mãi
    document.addEventListener('DOMContentLoaded', function() {
        // Tìm tất cả các gói dịch vụ
        const packageCards = document.querySelectorAll('.package-card');

        // Duyệt qua từng gói
        packageCards.forEach(card => {
            // Kiểm tra xem gói có badge khuyến mãi không
            const promotionBadge = card.querySelector('.promotion-badge');
            if (promotionBadge) {
                // Thêm class has-promotion
                card.classList.add('has-promotion');
            }
        });

        // Kiểm tra thiết bị di động
        function isMobile() {
            return window.innerWidth < 768 ||
                   navigator.userAgent.match(/Android/i) ||
                   navigator.userAgent.match(/webOS/i) ||
                   navigator.userAgent.match(/iPhone/i) ||
                   navigator.userAgent.match(/iPad/i) ||
                   navigator.userAgent.match(/iPod/i) ||
                   navigator.userAgent.match(/BlackBerry/i) ||
                   navigator.userAgent.match(/Windows Phone/i);
        }

        // Tối ưu hiệu ứng cho thiết bị di động
        if (isMobile()) {
            // Vô hiệu hóa một số hiệu ứng nặng trên thiết bị di động
            document.querySelectorAll('.parallax-bg').forEach(el => {
                el.style.backgroundAttachment = 'scroll';
            });

            // Giảm số lượng hiệu ứng animation
            document.querySelectorAll('.floating-icon').forEach(el => {
                el.style.animation = 'none';
            });
        }
    });

    // Dữ liệu dịch vụ
    const serviceData = {
        'ChatGPT': {
            title: 'ChatGPT Plus',
            description: 'ChatGPT Plus là phiên bản trả phí của ChatGPT, cung cấp truy cập ưu tiên vào các mô hình AI tiên tiến nhất của OpenAI, bao gồm GPT-4.5.',
            features: [
                'Truy cập đầy đủ tính năng GPT-4.5',
                'Không giới hạn tin nhắn và tải tệp',
                'Ưu tiên khi máy chủ bận',
                'Truy cập sớm tính năng mới',
                'Sử dụng trên mọi thiết bị',
                'Tài khoản chính chủ, an toàn tuyệt đối'
            ],
            price: '380.000 VNĐ/tháng',
            image: '/images/chatgpt.jpg',
            link: '#packages'
        },
        'Canva': {
            title: 'Canva Pro',
            description: 'Canva Pro là công cụ thiết kế đồ họa trực tuyến cao cấp, giúp bạn tạo ra các thiết kế chuyên nghiệp một cách dễ dàng.',
            features: [
                'Thêm thành viên gia đình',
                'Hơn 100 triệu hình ảnh, video premium',
                '610.000+ mẫu thiết kế chuyên nghiệp',
                'Công cụ xóa nền, Magic Edit',
                'Tạo nội dung AI với Text to Image',
                'Xuất file chất lượng cao không watermark'
            ],
            price: '150.000 VNĐ/năm',
            image: '/images/canva.jpg',
            link: '#packages'
        },
        'YouTube': {
            title: 'YouTube Premium',
            description: 'YouTube Premium cung cấp trải nghiệm xem video không quảng cáo, phát nền và tải xuống video để xem ngoại tuyến.',
            features: [
                'Xem video không quảng cáo',
                'Phát nhạc khi tắt màn hình',
                'Tải video xem offline',
                'Truy cập YouTube Music Premium',
                'Xem trên mọi thiết bị',
                'Chất lượng video tối đa'
            ],
            price: '250.000 VNĐ/năm',
            image: '/images/youtube.jpg',
            link: '#packages'
        },
        'Spotify': {
            title: 'Spotify Premium',
            description: 'Spotify Premium cho phép bạn nghe nhạc không quảng cáo, tải nhạc nghe offline và truy cập chất lượng âm thanh cao cấp.',
            features: [
                'Nghe nhạc không quảng cáo',
                'Tải nhạc nghe offline',
                'Chất lượng âm thanh cao cấp',
                'Phát bất kỳ bài hát nào',
                'Bỏ qua bài hát không giới hạn',
                'Chia sẻ với gia đình'
            ],
            price: '250.000 VNĐ/năm',
            image: '/images/spotify.jpg',
            link: '#packages'
        },
        'CapCut': {
            title: 'CapCut Pro',
            description: 'CapCut Pro là công cụ chỉnh sửa video chuyên nghiệp với nhiều hiệu ứng, bộ lọc và công cụ chỉnh sửa nâng cao.',
            features: [
                'Công cụ chỉnh sửa video chuyên nghiệp',
                'Thư viện hiệu ứng, nhạc nền premium',
                'Xuất video chất lượng cao không watermark',
                'Công cụ AI tiên tiến',
                'Tài khoản chính chủ, an toàn tuyệt đối',
                'Sử dụng trên mọi thiết bị'
            ],
            price: '600.000 VNĐ/năm',
            image: '/images/capcut.jpg',
            link: '#packages'
        }
    };

    // Xử lý khi nhấn vào các nút dịch vụ
    document.addEventListener('DOMContentLoaded', function() {
        const serviceBadges = document.querySelectorAll('.service-badge');

        serviceBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                // Chuyển hướng trực tiếp đến phần packages cho tất cả các dịch vụ
                window.location.href = '#packages';
            });
        });

        // Thêm hiệu ứng hover cho các nút dịch vụ (chỉ trên desktop)
        if (window.innerWidth >= 768) {
            serviceBadges.forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.classList.add('badge-hover');
                });

                badge.addEventListener('mouseleave', function() {
                    this.classList.remove('badge-hover');
                });
            });
        } else {
            // Thêm hiệu ứng touch cho thiết bị di động
            serviceBadges.forEach(badge => {
                badge.addEventListener('touchstart', function() {
                    this.classList.add('badge-active');
                });

                badge.addEventListener('touchend', function() {
                    this.classList.remove('badge-active');
                    setTimeout(() => {
                        this.classList.remove('badge-active');
                    }, 300);
                });
            });
        }

        // Xử lý responsive cho các phần tử khác
        window.addEventListener('resize', function() {
            // Điều chỉnh giao diện khi thay đổi kích thước màn hình
            if (window.innerWidth < 768) {
                // Tối ưu cho thiết bị di động
                document.querySelectorAll('.parallax-bg').forEach(el => {
                    el.style.backgroundAttachment = 'scroll';
                });
            }
        });
    });
</script>
@endsection
