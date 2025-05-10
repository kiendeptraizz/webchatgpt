/**
 * Mobile image effects for Trung Kiên Unlock
 * This file contains JavaScript for mobile image effects and optimizations
 */

document.addEventListener('DOMContentLoaded', function() {
    // Detect mobile devices
    const isMobile = () => {
        return window.innerWidth < 768 || 
               navigator.userAgent.match(/Android/i) || 
               navigator.userAgent.match(/webOS/i) || 
               navigator.userAgent.match(/iPhone/i) || 
               navigator.userAgent.match(/iPad/i) || 
               navigator.userAgent.match(/iPod/i) || 
               navigator.userAgent.match(/BlackBerry/i) || 
               navigator.userAgent.match(/Windows Phone/i);
    };
    
    // Only run on mobile devices
    if (!isMobile()) return;
    
    // Add animation on scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.animate-on-scroll');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('visible');
            }
        });
    };
    
    // Add animate-on-scroll class to elements
    document.querySelectorAll('.package-card, .card, .tech-frame-mobile, .category-header').forEach(el => {
        el.classList.add('animate-on-scroll');
    });
    
    // Run animation on scroll
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run once on load
    
    // Add image placeholders
    document.querySelectorAll('img').forEach(img => {
        // Skip images that are already loaded
        if (img.complete) return;
        
        // Create placeholder
        const placeholder = document.createElement('div');
        placeholder.className = 'img-placeholder';
        placeholder.style.width = img.width + 'px';
        placeholder.style.height = img.height + 'px';
        placeholder.style.borderRadius = getComputedStyle(img).borderRadius;
        
        // Replace image with placeholder
        img.parentNode.insertBefore(placeholder, img);
        img.style.display = 'none';
        
        // Remove placeholder when image loads
        img.onload = function() {
            img.style.display = '';
            if (placeholder.parentNode) {
                placeholder.parentNode.removeChild(placeholder);
            }
        };
    });
    
    // Add tilt effect to hero image
    const techFrameMobile = document.querySelector('.tech-frame-mobile');
    if (techFrameMobile) {
        techFrameMobile.addEventListener('touchmove', function(e) {
            const touch = e.touches[0];
            const rect = techFrameMobile.getBoundingClientRect();
            
            const x = touch.clientX - rect.left;
            const y = touch.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateY = (x - centerX) / centerX * 5;
            const rotateX = (centerY - y) / centerY * 5;
            
            techFrameMobile.style.transform = `perspective(1000px) rotateY(${rotateY}deg) rotateX(${rotateX}deg)`;
        });
        
        techFrameMobile.addEventListener('touchend', function() {
            techFrameMobile.style.transform = 'perspective(1000px) rotateY(0deg) rotateX(0deg)';
        });
    }
    
    // Add zoom effect to images
    document.querySelectorAll('.testimonial-avatar, .service-badge img, .category-icon').forEach(img => {
        img.classList.add('img-zoomable');
    });
    
    // Optimize background images
    document.querySelectorAll('[style*="background-image"]').forEach(el => {
        el.classList.add('bg-image');
    });
    
    // Add lazy loading for background images
    const lazyBackgrounds = document.querySelectorAll('.lazy-background');
    
    if ('IntersectionObserver' in window) {
        const backgroundObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const bg = target.getAttribute('data-bg');
                    
                    if (bg) {
                        target.style.backgroundImage = `url(${bg})`;
                    }
                    
                    backgroundObserver.unobserve(target);
                }
            });
        });
        
        lazyBackgrounds.forEach(bg => {
            backgroundObserver.observe(bg);
        });
    } else {
        // Fallback for browsers that don't support IntersectionObserver
        lazyBackgrounds.forEach(bg => {
            const bgUrl = bg.getAttribute('data-bg');
            if (bgUrl) {
                bg.style.backgroundImage = `url(${bgUrl})`;
            }
        });
    }
});
