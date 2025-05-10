<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#4361ee">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Trung Kiên Unlock - Đồng hành cùng bạn, mở lối công nghệ. Cung cấp các dịch vụ AI và công nghệ cao cấp với giá tốt nhất thị trường.">
    <meta name="keywords" content="Trung Kiên Unlock, ChatGPT, AI, Canva Pro, YouTube Premium, Spotify Premium, CapCut Pro, Grok AI, dịch vụ AI, tài khoản chính chủ">
    <meta name="author" content="Trung Kiên Unlock">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Trung Kiên Unlock - Đồng hành cùng bạn, mở lối công nghệ')">
    <meta property="og:description" content="Cung cấp các dịch vụ AI và công nghệ cao cấp với giá tốt nhất thị trường.">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Trung Kiên Unlock - Đồng hành cùng bạn, mở lối công nghệ')">
    <meta property="twitter:description" content="Cung cấp các dịch vụ AI và công nghệ cao cấp với giá tốt nhất thị trường.">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    @if(session('error'))
        <meta name="error" content="{{ session('error') }}">
    @endif

    <title>@yield('title', 'Trung Kiên Unlock - Đồng hành cùng bạn, mở lối công nghệ')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpg" href="{{ asset('images/logo1.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/promotion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/package-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/enhanced-pricing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-images.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-forms.css') }}">
    <style>
        :root {
            /* Main Colors */
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #16213e;
            --success-color: #4CAF50;
            --info-color: #2196F3;
            --warning-color: #ff9800;
            --danger-color: #f44336;

            /* Gradients */
            --tech-gradient: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            --tech-gradient-alt: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%);
            --cool-gradient: linear-gradient(135deg, #4cc9f0 0%, #4361ee 100%);
            --warm-gradient: linear-gradient(135deg, #f72585 0%, #7209b7 100%);
            --badge-gradient: linear-gradient(135deg, #4361ee, #7209b7);

            /* Effects */
            --neon-shadow: 0 0 10px rgba(67, 97, 238, 0.7), 0 0 20px rgba(67, 97, 238, 0.5);
            --tech-border: 1px solid rgba(67, 97, 238, 0.3);
            --glow-color: rgba(76, 201, 240, 0.8);

            /* Glass Morphism */
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: 1px solid rgba(255, 255, 255, 0.18);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            --glass-radius: 10px;
            --glass-blur: 10px;

            /* Typography */
            --heading-font: 'Poppins', sans-serif;
            --body-font: 'Inter', sans-serif;
            --base-font-size: 16px;
            --h1-size: 3rem;
            --h2-size: 2.5rem;
            --h3-size: 2rem;
            --h4-size: 1.5rem;
            --h5-size: 1.25rem;
            --h6-size: 1rem;
        }

        /* Tech UI Elements */
        .tech-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: var(--tech-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
        }

        .tech-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--tech-gradient);
        }

        .tech-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--neon-shadow);
        }

        .tech-bg {
            position: relative;
            overflow: hidden;
        }

        .tech-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(67, 97, 238, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            z-index: -1;
        }

        .tech-grid {
            position: relative;
        }

        .tech-grid::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(67, 97, 238, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(67, 97, 238, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: -1;
        }

        .tech-btn {
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .tech-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            z-index: -1;
        }

        .tech-btn:hover::before {
            left: 100%;
        }

        .tech-glow {
            box-shadow: var(--neon-shadow);
        }

        /* Chat Support Button */
        .chat-support-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            cursor: pointer;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
            border: 2px solid rgba(255, 255, 255, 0.7);
        }

        .chat-support-btn:hover {
            transform: scale(1.1) rotate(10deg);
            background: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        .chat-support-btn::after {
            content: '';
            position: absolute;
            width: 85px;
            height: 85px;
            border-radius: 50%;
            border: 2px dashed rgba(255, 255, 255, 0.5);
            animation: spin 15s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .chat-support-tooltip {
            position: absolute;
            top: -45px;
            right: 0;
            background-color: white;
            color: var(--dark-color);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transition: all 0.3s ease;
            white-space: nowrap;
            border-left: 4px solid var(--primary-color);
        }

        .chat-support-tooltip::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 30px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 8px solid white;
        }

        .chat-support-btn:hover .chat-support-tooltip {
            opacity: 1;
            top: -55px;
        }

        .chat-notification {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #ff4757;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            border: 2px solid white;
            animation: bounce 1s infinite alternate;
        }

        @keyframes bounce {
            from { transform: scale(1); }
            to { transform: scale(1.2); }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.7);
            }
            70% {
                box-shadow: 0 0 0 20px rgba(67, 97, 238, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(67, 97, 238, 0);
            }
        }

        body {
            font-family: var(--body-font);
            color: #333;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-size: var(--base-font-size);
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--heading-font);
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: var(--h1-size);
            font-weight: 800;
        }

        h2 {
            font-size: var(--h2-size);
        }

        h3 {
            font-size: var(--h3-size);
        }

        h4 {
            font-size: var(--h4-size);
        }

        h5 {
            font-size: var(--h5-size);
        }

        h6 {
            font-size: var(--h6-size);
        }

        p {
            margin-bottom: 1rem;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand span {
            color: var(--primary-color);
            position: relative;
        }

        .navbar-brand span::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 4px;
            bottom: -4px;
            left: 0;
            background: var(--tech-gradient);
            border-radius: 2px;
        }

        .logo-container {
            position: relative;
            overflow: hidden;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .logo-container:hover {
            transform: rotate(10deg);
            box-shadow: var(--neon-shadow);
        }

        .slogan-text {
            background: var(--tech-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 500;
        }

        .navbar {
            box-shadow: var(--glass-shadow);
            background-color: var(--glass-bg);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border-bottom: var(--glass-border);
            transition: all 0.3s ease;
        }

        .nav-link {
            font-weight: 500;
            color: #333;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: var(--tech-gradient);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            opacity: 0;
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 80%;
            opacity: 1;
        }

        .nav-link:hover {
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* User Dropdown Styles */
        .user-dropdown-btn {
            background: var(--cool-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            border-radius: 30px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .user-dropdown-btn:hover,
        .user-dropdown-btn:focus {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.5);
            background: var(--tech-gradient);
        }

        .user-dropdown-menu {
            background: var(--glass-bg);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: var(--glass-radius);
            box-shadow: var(--glass-shadow);
            padding: 0.8rem 0;
            margin-top: 0.5rem;
            min-width: 220px;
            animation: dropdown-fade 0.3s ease;
        }

        @keyframes dropdown-fade {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-dropdown-menu .dropdown-item {
            padding: 0.7rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
            display: flex;
            align-items: center;
        }

        .user-dropdown-menu .dropdown-item:hover {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .user-dropdown-menu .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            font-size: 1rem;
        }

        .user-dropdown-menu .dropdown-header {
            padding: 0.7rem 1.5rem;
            color: var(--dark-color);
        }

        .user-dropdown-menu .dropdown-divider {
            margin: 0.5rem 0;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background: var(--tech-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            border-radius: 30px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--tech-gradient-alt);
            transition: all 0.5s ease;
            z-index: -1;
            border-radius: 30px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.5);
            border: none;
        }

        .btn-primary:hover::before {
            width: 100%;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: 30px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .btn-outline-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--tech-gradient);
            transition: all 0.5s ease;
            z-index: -1;
            border-radius: 30px;
        }

        .btn-outline-primary:hover {
            color: white;
            border-color: transparent;
            background: transparent;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3);
        }

        .btn-outline-primary:hover::before {
            left: 0;
        }

        .hero-section {
            background: var(--tech-gradient);
            color: white;
            padding: 100px 0 80px;
            margin-bottom: 0;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            z-index: 2;
        }

        .hero-title {
            font-weight: 800;
            font-size: 3rem;
            line-height: 1.2;
            margin-bottom: 20px;
            position: relative;
        }

        .gradient-text {
            background: linear-gradient(90deg, #4cc9f0, #f72585);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            display: inline-block;
        }

        .typing-text {
            position: relative;
            display: inline-block;
        }

        .typing-text::after {
            content: '|';
            position: absolute;
            right: -10px;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        .hero-subtitle {
            font-weight: 400;
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
            max-width: 90%;
        }

        .tech-circle {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(76, 201, 240, 0.1) 0%, rgba(0, 0, 0, 0) 70%);
            top: -150px;
            left: -150px;
            z-index: -1;
        }

        .tech-dots {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
            background-size: 20px 20px;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .tech-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .badge-container {
            perspective: 1000px;
        }

        .badge-tech {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform-style: preserve-3d;
        }

        .badge-tech i {
            color: var(--accent-color);
        }

        .badge-tech:hover {
            transform: translateY(-3px) rotateX(10deg);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: var(--badge-gradient);
            border-color: var(--accent-color);
        }

        .hero-image-container {
            padding: 20px;
        }

        .tech-frame {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--neon-shadow);
            transform: perspective(1000px) rotateY(-5deg);
            transition: all 0.5s ease;
            border: 2px solid rgba(67, 97, 238, 0.3);
        }

        .tech-frame:hover {
            transform: perspective(1000px) rotateY(0deg);
            box-shadow: 0 0 20px var(--glow-color);
        }

        .frame-corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid var(--accent-color);
            z-index: 3;
        }

        .top-left {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }

        .top-right {
            top: 10px;
            right: 10px;
            border-left: none;
            border-bottom: none;
        }

        .bottom-left {
            bottom: 10px;
            left: 10px;
            border-right: none;
            border-top: none;
        }

        .bottom-right {
            bottom: 10px;
            right: 10px;
            border-left: none;
            border-top: none;
        }

        .tech-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.2) 0%, rgba(58, 12, 163, 0.2) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .tech-circle-1 {
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px dashed rgba(76, 201, 240, 0.3);
            top: -30px;
            right: -30px;
            animation: spin 20s linear infinite;
        }

        .tech-circle-2 {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px dashed rgba(76, 201, 240, 0.3);
            bottom: -20px;
            left: -20px;
            animation: spin 15s linear infinite reverse;
        }

        .floating-icon {
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 2;
            animation: float 3s infinite alternate ease-in-out;
        }

        .icon-lg {
            width: 60px;
            height: 60px;
            font-size: 24px;
            color: var(--primary-color);
            animation-duration: 4s;
        }

        .icon-md {
            width: 50px;
            height: 50px;
            font-size: 20px;
            color: var(--secondary-color);
            animation-duration: 3s;
        }

        .icon-sm {
            width: 40px;
            height: 40px;
            font-size: 16px;
            color: var(--accent-color);
            animation-duration: 5s;
        }

        .icon-xs {
            width: 30px;
            height: 30px;
            font-size: 12px;
            color: var(--info-color);
            animation-duration: 2.5s;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-10px) rotate(5deg); }
        }

        .tech-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .tech-particles::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(rgba(255, 255, 255, 0.2) 1px, transparent 1px),
                radial-gradient(rgba(255, 255, 255, 0.15) 2px, transparent 2px);
            background-size: 30px 30px, 60px 60px;
            background-position: 0 0, 15px 15px;
            animation: particleMove 20s linear infinite;
        }

        @keyframes particleMove {
            0% {
                background-position: 0 0, 15px 15px;
            }
            100% {
                background-position: 30px 30px, 45px 45px;
            }
        }

        .tech-lines {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            opacity: 0.5;
        }

        .tech-lines::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 200%;
            height: 200%;
            background-image:
                linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            transform: rotate(25deg);
            animation: lineMove 30s linear infinite;
        }

        @keyframes lineMove {
            0% {
                transform: rotate(25deg) translateY(0);
            }
            100% {
                transform: rotate(25deg) translateY(-50%);
            }
        }

        .search-box {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 5px;
            backdrop-filter: blur(5px);
        }

        .search-border {
            position: absolute;
            bottom: 0;
            left: 10%;
            width: 80%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        }

        .search-box .form-control {
            border-radius: 30px;
            border: none;
            padding-left: 20px;
            box-shadow: none;
        }

        .search-box .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-box .btn {
            border-radius: 30px;
            padding: 10px 25px;
            margin-right: 5px;
        }

        .btn-glow {
            position: relative;
            overflow: hidden;
            background: var(--primary-color);
            border: none;
            box-shadow: 0 0 10px var(--glow-color);
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            box-shadow: 0 0 20px var(--glow-color);
            transform: translateY(-2px);
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .tech-stats {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stat-item {
            padding: 15px;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 24px;
            height: 50px;
            width: 50px;
            line-height: 50px;
            border-radius: 50%;
            display: inline-block;
            background: rgba(67, 97, 238, 0.1);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .stat-text {
            color: #6c757d;
            font-weight: 500;
        }

        .package-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            position: relative;
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .package-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: 0 15px 50px rgba(67, 97, 238, 0.3);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            z-index: -1;
        }

        .package-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: rgba(67, 97, 238, 0.2);
        }

        .package-card:hover::before {
            opacity: 1;
        }

        .package-header {
            background: var(--tech-gradient);
            color: white;
            padding: 25px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .package-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            z-index: 1;
        }

        .package-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        }

        .package-title {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .package-price {
            font-size: 2.2rem;
            font-weight: 700;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            display: inline-block;
            margin: 15px 0;
        }

        .package-price::before {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background: rgba(255, 255, 255, 0.5);
        }

        .package-price small {
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.8;
        }

        .package-body {
            padding: 25px;
            background-color: white;
            position: relative;
        }

        .package-body p {
            color: #6c757d;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .feature-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 25px;
        }

        .feature-list li {
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            padding-left: 30px;
            font-size: 0.95rem;
            color: #495057;
            transition: all 0.3s ease;
        }

        .feature-list li:last-child {
            border-bottom: none;
        }

        .feature-list li:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .feature-list li::before {
            content: '✓';
            color: white;
            position: absolute;
            left: 0;
            top: 10px;
            font-weight: bold;
            background: var(--primary-color);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            box-shadow: 0 2px 5px rgba(67, 97, 238, 0.3);
        }

        .package-card .btn {
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .package-card .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            z-index: -1;
        }

        .package-card .btn:hover::before {
            left: 100%;
        }

        .package-badge {
            position: absolute;
            top: -10px;
            right: 20px;
            background: var(--accent-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 3;
        }

        /* Section Title Styles */
        .section-title-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .section-title {
            position: relative;
            z-index: 2;
            display: inline-block;
            padding: 0 15px;
        }

        .section-title-decoration {
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 10px;
            background: rgba(67, 97, 238, 0.1);
            z-index: 1;
            border-radius: 5px;
        }

        /* Category Header Styles */
        .category-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }

        .category-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
            flex-shrink: 0;
        }

        .category-icon i {
            font-size: 24px;
            color: white;
        }

        .category-title {
            flex-grow: 1;
        }

        .category-line {
            height: 3px;
            width: 100%;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            margin-top: 5px;
        }

        /* Subcategory Header Styles */
        .subcategory-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .subcategory-icon {
            width: 40px;
            height: 40px;
            background: var(--info-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .subcategory-icon i {
            font-size: 16px;
            color: white;
        }

        /* Comparison Table Styles */
        .comparison-table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .comparison-table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid rgba(0, 0, 0, 0.05);
            padding: 15px;
            vertical-align: middle;
        }

        .comparison-table .feature-column {
            background-color: #f8f9fa;
            width: 25%;
        }

        .plan-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .plan-badge {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            font-size: 0.8rem;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 500;
        }

        .price-row {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .price-value {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .price-period {
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .feature-name {
            font-weight: 600;
            color: #495057;
        }

        .feature-highlight {
            font-weight: 700;
            color: var(--primary-color);
        }

        .highlight-primary {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .highlight-success {
            background-color: rgba(76, 175, 80, 0.05);
        }

        .highlight-info {
            background-color: rgba(33, 150, 243, 0.05);
        }

        .comparison-table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.02);
        }

        .footer {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 60px 0 20px;
            margin-top: auto;
            position: relative;
            overflow: hidden;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                radial-gradient(rgba(255, 255, 255, 0.05) 2px, transparent 2px);
            background-size: 30px 30px, 60px 60px;
            background-position: 0 0, 15px 15px;
            pointer-events: none;
        }

        .footer h5 {
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        .footer h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--tech-gradient);
            border-radius: 2px;
        }

        .footer-links {
            list-style-type: none;
            padding-left: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 15px;
        }

        .footer-links li::before {
            content: '›';
            position: absolute;
            left: 0;
            top: 0;
            color: var(--primary-color);
            font-size: 18px;
            line-height: 1;
            transition: all 0.3s ease;
        }

        .footer-links li:hover {
            transform: translateX(5px);
        }

        .footer-links li:hover::before {
            color: var(--accent-color);
        }

        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: white;
            text-decoration: none;
        }

        .social-icons {
            display: flex;
            gap: 15px;
        }

        .social-icons a {
            color: white;
            font-size: 1.2rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-icons a:hover {
            color: white;
            background: var(--tech-gradient);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border-color: transparent;
        }

        .copyright {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            color: rgba(255,255,255,0.7);
            position: relative;
        }

        .copyright::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: var(--tech-gradient);
        }

        /* Detail page styles */
        .detail-header {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }

        .detail-title {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .detail-price {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 15px 0;
        }

        .detail-description {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .detail-content {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        .subscription-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 30px;
        }

        .form-title {
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--dark-color);
        }

        /* Scroll Animation Styles */
        .fade-up-element {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-up-element.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-item {
            transition-delay: calc(var(--i) * 100ms);
        }

        /* Parallax Effect */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* Hover Effects */
        .hover-float {
            transition: transform 0.3s ease;
        }

        .hover-float:hover {
            transform: translateY(-10px);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .hover-glow {
            transition: box-shadow 0.3s ease;
        }

        .hover-glow:hover {
            box-shadow: 0 0 20px var(--glow-color);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            /* General adjustments */
            body {
                font-size: 14px;
            }

            /* Header/Navbar adjustments */
            .navbar {
                padding: 10px 0;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .logo-container img {
                width: 40px;
                height: 40px;
            }

            /* Hero section adjustments */
            .hero-section {
                padding: 40px 0;
            }

            .hero-title {
                font-size: 1.8rem;
                line-height: 1.3;
            }

            .hero-subtitle {
                font-size: 1rem;
                max-width: 100%;
            }

            .search-box {
                width: 100%;
            }

            .search-box .form-control {
                font-size: 14px;
                padding: 8px 15px;
            }

            .search-box .btn {
                padding: 8px 15px;
                font-size: 14px;
            }

            /* Package card adjustments */
            .package-card {
                margin-bottom: 20px;
            }

            .package-header {
                padding: 15px;
            }

            .package-title {
                font-size: 1.3rem;
            }

            .package-price {
                font-size: 1.8rem;
            }

            .package-body {
                padding: 15px;
            }

            .feature-list li {
                font-size: 0.9rem;
                padding: 8px 0 8px 25px;
            }

            .feature-list li::before {
                width: 18px;
                height: 18px;
                font-size: 10px;
                top: 8px;
            }

            /* Category header adjustments */
            .category-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .category-icon {
                margin-bottom: 10px;
                width: 50px;
                height: 50px;
            }

            /* Chat support button adjustments */
            .chat-support-btn {
                width: 60px;
                height: 60px;
                font-size: 24px;
                bottom: 20px;
                right: 20px;
            }

            /* Footer adjustments */
            .footer {
                padding: 40px 0 20px;
            }

            /* Disable parallax on mobile */
            .parallax-bg {
                background-attachment: scroll;
            }
        }

        /* Small mobile devices */
        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.5rem;
            }

            .hero-subtitle {
                font-size: 0.9rem;
            }

            .package-title {
                font-size: 1.2rem;
            }

            .package-price {
                font-size: 1.6rem;
            }

            .chat-support-btn {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .chat-support-tooltip {
                display: none;
            }

            .section-title {
                font-size: 1.5rem;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <div class="logo-container me-2">
                    <img src="{{ asset('images/logo1.jpg') }}" alt="Trung Kiên Unlock Logo" width="50" height="50" class="d-inline-block align-top rounded-circle shadow-sm border border-light">
                </div>
                <div>
                    <span class="fw-bold">Trung Kiên</span><span style="color: var(--primary-color)"> Unlock</span>
                    <div class="slogan-text" style="font-size: 12px; line-height: 1; opacity: 0.8; font-style: italic;">Đồng hành cùng bạn, mở lối công nghệ</div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('features') ? 'active' : '' }}" href="{{ route('features') }}">Tính năng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#packages">Bảng giá</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Liên hệ</a>
                    </li>
                </ul>
                <div class="ms-lg-3">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                    @else
                        <div class="dropdown">
                            <a class="btn btn-primary dropdown-toggle user-dropdown-btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                                @if(Auth::user()->isAdmin())
                                    <li class="dropdown-header text-center">
                                        <span class="badge bg-primary mb-2">Admin</span>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Quản trị</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-user me-2"></i>Dashboard</a></li>
                                <li>
                                    <a class="dropdown-item position-relative" href="{{ route('chat') }}">
                                        <i class="fas fa-comments me-2"></i>Chat hỗ trợ
                                        @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                {{ $unreadMessagesCount }}
                                                <span class="visually-hidden">tin nhắn chưa đọc</span>
                                            </span>
                                        @endif
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Chat Support Button -->
    <a href="{{ route('chat') }}" class="chat-support-btn" id="chatSupportBtn">
        <i class="fas fa-headset"></i>
        <span class="chat-support-tooltip">Chat ngay với tư vấn viên</span>
        @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
            <div class="chat-notification">{{ $unreadMessagesCount }}</div>
        @endif
    </a>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="mb-4 d-flex align-items-center">
                        <img src="{{ asset('images/logo1.jpg') }}" alt="Trung Kiên Unlock Logo" width="40" height="40" class="me-2 rounded-circle shadow-sm border border-light">
                        <span class="fw-bold">Trung Kiên</span><span style="color: var(--primary-color)"> Unlock</span>
                    </h5>
                    <p class="mb-2">Đồng hành cùng bạn, mở lối công nghệ</p>
                    <p>Cung cấp các dịch vụ AI và công nghệ cao cấp với giá tốt nhất thị trường.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5>Liên kết nhanh</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li><a href="{{ route('features') }}">Tính năng</a></li>
                        <li><a href="{{ route('home') }}#packages">Bảng giá</a></li>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5>Hỗ trợ khách hàng</h5>
                    <ul class="footer-links">
                        <li><a href="#">Trung tâm hỗ trợ</a></li>
                        <li><a href="#">Câu hỏi thường gặp</a></li>
                        <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Điều khoản sử dụng</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h5>Liên hệ với chúng tôi</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> Xuân Phương, Nam Từ Liêm, Hà Nội</p>
                    <p><i class="fas fa-phone-alt me-2"></i> 0378059206</p>
                    <p><i class="fab fa-whatsapp me-2"></i> Zalo: 0378059206</p>
                    <p><i class="fas fa-envelope me-2"></i> trkien1804@gmail.com</p>

                    <div class="mt-4">
                        <h6 class="mb-2">Phương thức thanh toán</h6>
                        <div class="payment-methods">
                            <i class="fab fa-cc-visa me-2 fs-4"></i>
                            <i class="fab fa-cc-mastercard me-2 fs-4"></i>
                            <i class="fab fa-cc-paypal me-2 fs-4"></i>
                            <img src="{{ asset('images/momo.png') }}" alt="MoMo" width="24" height="24" class="me-2">
                            <img src="{{ asset('images/vnpay.png') }}" alt="VNPay" width="24" height="24">
                        </div>
                    </div>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; {{ date('Y') }} Trung Kiên Unlock. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <!-- Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Trung Kiên Unlock",
        "slogan": "Đồng hành cùng bạn, mở lối công nghệ",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo1.jpg') }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+84378059206",
            "email": "trkien1804@gmail.com",
            "contactType": "customer service",
            "availableLanguage": ["Vietnamese", "English"]
        },
        "sameAs": [
            "https://www.facebook.com/trungkienunlock",
            "https://twitter.com/trungkienunlock",
            "https://www.instagram.com/trungkienunlock",
            "https://www.youtube.com/trungkienunlock"
        ],
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Xuân Phương",
            "addressLocality": "Nam Từ Liêm",
            "addressRegion": "Hà Nội",
            "postalCode": "100000",
            "addressCountry": "VN"
        },
        "offers": {
            "@type": "AggregateOffer",
            "priceCurrency": "VND",
            "lowPrice": "69000",
            "highPrice": "600000",
            "offerCount": "10"
        }
    }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS - Animate On Scroll Library -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <!-- Custom JS -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false,
            offset: 50
        });
        // Show chat tooltip after 2 seconds
        setTimeout(function() {
            const chatBtn = document.querySelector('.chat-support-btn');
            if (chatBtn) {
                const tooltip = chatBtn.querySelector('.chat-support-tooltip');
                if (tooltip) {
                    tooltip.style.opacity = '1';
                    tooltip.style.top = '-55px';

                    // Hide tooltip after 5 seconds
                    setTimeout(function() {
                        tooltip.style.opacity = '0';
                        tooltip.style.top = '-45px';

                        // Show tooltip again after 30 seconds
                        setTimeout(function() {
                            tooltip.style.opacity = '1';
                            tooltip.style.top = '-55px';

                            // And hide again after 5 seconds
                            setTimeout(function() {
                                tooltip.style.opacity = '0';
                                tooltip.style.top = '-45px';
                            }, 5000);
                        }, 30000);
                    }, 5000);
                }

                // Add bounce effect to chat button every 15 seconds
                setInterval(function() {
                    chatBtn.classList.add('bounce-effect');
                    setTimeout(function() {
                        chatBtn.classList.remove('bounce-effect');
                    }, 1000);
                }, 15000);

                // Không cần cập nhật số thông báo ngẫu nhiên nữa vì đã có thông báo thực
            }
        }, 2000);

        // Package search functionality
        const searchInput = document.getElementById('searchPackage');
        const searchButton = document.getElementById('searchButton');

        // Function to perform search
        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase();
            const packageCards = document.querySelectorAll('.package-card');
            const searchResultsInfo = document.getElementById('searchResultsInfo');
            const searchResultsCount = document.getElementById('searchResultsCount');

            // If search term is empty, show all packages and sections
            if (searchTerm.trim() === '') {
                packageCards.forEach(card => {
                    const parentCol = card.closest('.col-lg-6, .col-lg-4');
                    if (parentCol) {
                        parentCol.style.display = '';
                    }
                });

                const sections = document.querySelectorAll('#packages > .container > div.mb-5');
                sections.forEach(section => {
                    section.style.display = '';
                });

                // Hide search results info
                if (searchResultsInfo) {
                    searchResultsInfo.style.display = 'none';
                }
                return;
            }

            let visibleCount = 0;
            packageCards.forEach(card => {
                const title = card.querySelector('.package-title').textContent.toLowerCase();
                const features = Array.from(card.querySelectorAll('.feature-list li')).map(li => li.textContent.toLowerCase());
                const description = card.querySelector('.package-body p') ? card.querySelector('.package-body p').textContent.toLowerCase() : '';

                const isVisible =
                    title.includes(searchTerm) ||
                    features.some(feature => feature.includes(searchTerm)) ||
                    description.includes(searchTerm);

                // Get the parent column
                const parentCol = card.closest('.col-lg-6, .col-lg-4');
                if (parentCol) {
                    if (isVisible) {
                        parentCol.style.display = '';
                        visibleCount++;
                        // Add highlight animation
                        if (searchTerm.length > 2) {
                            card.classList.add('search-highlight');
                            setTimeout(() => {
                                card.classList.remove('search-highlight');
                            }, 1000);
                        }
                    } else {
                        parentCol.style.display = 'none';
                    }
                }
            });

            // Check if any packages are visible in each section
            const sections = document.querySelectorAll('#packages > .container > div.mb-5');
            sections.forEach(section => {
                const visiblePackages = section.querySelectorAll('.package-card').length;
                const visibleColumns = Array.from(section.querySelectorAll('.col-lg-6, .col-lg-4')).filter(col => col.style.display !== 'none').length;

                // If no packages are visible in this section, hide the section
                if (visibleColumns === 0 && visiblePackages > 0) {
                    section.style.display = 'none';
                } else {
                    section.style.display = '';
                }
            });

            // Update search results info
            if (searchResultsInfo && searchResultsCount) {
                searchResultsInfo.style.display = 'block';
                searchResultsCount.textContent = `Tìm thấy ${visibleCount} gói dịch vụ phù hợp với "${searchTerm}"`;
            }

            // Scroll to packages section if not already visible
            const packagesSection = document.getElementById('packages');
            if (packagesSection) {
                packagesSection.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Add event listeners if search elements exist
        if (searchInput) {
            // Add keyup event listener
            searchInput.addEventListener('keyup', function(event) {
                performSearch();

                // Also trigger search on Enter key
                if (event.key === 'Enter') {
                    performSearch();
                }
            });

            // Add click event listener to search button
            if (searchButton) {
                console.log('Search button found, adding click listener');
                searchButton.addEventListener('click', function() {
                    console.log('Search button clicked');
                    performSearch();
                });
            } else {
                console.log('Search button not found');
            }

            // Add direct event listener to any button in search box as fallback
            const searchBox = document.querySelector('.search-box');
            if (searchBox) {
                const anyButton = searchBox.querySelector('button');
                if (anyButton && anyButton !== searchButton) {
                    console.log('Using fallback button');
                    anyButton.addEventListener('click', function() {
                        performSearch();
                    });
                }

                // Add clear search functionality
                const clearSearch = document.getElementById('clearSearch');
                if (clearSearch) {
                    clearSearch.addEventListener('click', function(e) {
                        e.preventDefault();
                        searchInput.value = '';
                        performSearch();
                        searchInput.focus();
                    });
                }
            }
        }

        // Typing animation for hero section
        const typingText = document.querySelector('.typing-text');
        if (typingText) {
            const words = ['Cao cấp', 'Chuyên nghiệp', 'Tiết kiệm', 'Uy tín'];
            let wordIndex = 0;
            let charIndex = 0;
            let isDeleting = false;
            let typingSpeed = 100;

            function type() {
                const currentWord = words[wordIndex];

                if (isDeleting) {
                    // Deleting text
                    typingText.textContent = currentWord.substring(0, charIndex - 1);
                    charIndex--;
                    typingSpeed = 50;
                } else {
                    // Typing text
                    typingText.textContent = currentWord.substring(0, charIndex + 1);
                    charIndex++;
                    typingSpeed = 150;
                }

                // If word is complete, start deleting after pause
                if (!isDeleting && charIndex === currentWord.length) {
                    isDeleting = true;
                    typingSpeed = 1000; // Pause at end of word
                }

                // If word is deleted, move to next word
                if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    wordIndex = (wordIndex + 1) % words.length;
                }

                setTimeout(type, typingSpeed);
            }

            // Start typing animation
            setTimeout(type, 1000);
        }
    });
    </script>

    <style>
    .bounce-effect {
        animation: button-bounce 0.5s ease;
    }

    @keyframes button-bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .search-highlight {
        animation: highlight-pulse 1s ease;
    }

    @keyframes highlight-pulse {
        0% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(67, 97, 238, 0); }
        100% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0); }
    }

    .search-results-info {
        font-size: 0.9rem;
        opacity: 0.9;
        padding: 5px 10px;
        border-radius: 20px;
        background-color: rgba(255, 255, 255, 0.1);
        display: inline-block;
    }

    #clearSearch:hover {
        color: #f8f9fa !important;
        text-decoration: underline !important;
    }

    .service-badge {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .badge-hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .price-tag {
        background-color: #f8f9fa;
        color: #212529;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 1.1rem;
        text-align: center;
    }
    </style>

    <script src="{{ asset('js/mobile-optimizations.js') }}"></script>
    <script src="{{ asset('js/mobile-features.js') }}"></script>
    <script src="{{ asset('js/mobile-image-effects.js') }}"></script>
    @yield('scripts')
</body>
</html>
