/**
 * Mobile optimizations for Trung Kiên Unlock
 * This file contains JavaScript optimizations for mobile devices
 */

document.addEventListener("DOMContentLoaded", function () {
    // Detect mobile devices
    const isMobile = () => {
        return (
            window.innerWidth < 768 ||
            navigator.userAgent.match(/Android/i) ||
            navigator.userAgent.match(/webOS/i) ||
            navigator.userAgent.match(/iPhone/i) ||
            navigator.userAgent.match(/iPad/i) ||
            navigator.userAgent.match(/iPod/i) ||
            navigator.userAgent.match(/BlackBerry/i) ||
            navigator.userAgent.match(/Windows Phone/i)
        );
    };

    // Detect iOS devices
    const isIOS = () => {
        return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    };

    // Detect slow connections
    const isSlowConnection = () => {
        return (
            navigator.connection &&
            (navigator.connection.saveData ||
                navigator.connection.effectiveType.includes("2g") ||
                navigator.connection.effectiveType.includes("slow"))
        );
    };

    // Apply mobile optimizations
    if (isMobile()) {
        console.log("Mobile device detected, applying optimizations");

        // Disable heavy animations
        document.querySelectorAll(".parallax-bg").forEach((el) => {
            el.style.backgroundAttachment = "scroll";
        });

        document.querySelectorAll(".floating-icon").forEach((el) => {
            el.style.animation = "none";
        });

        // Optimize images
        document.querySelectorAll("img").forEach((img) => {
            // Add loading="lazy" attribute to all images
            img.setAttribute("loading", "lazy");

            // Add decoding="async" for better performance
            img.setAttribute("decoding", "async");

            // If on slow connection, load lower quality images if available
            if (
                (isSlowConnection() && img.src.includes(".jpg")) ||
                img.src.includes(".png")
            ) {
                // Check if there's a mobile version of the image
                const mobileSrc = img.src.replace(/\.(jpg|png)$/, "-mobile.$1");

                // Create a test image to see if mobile version exists
                const testImg = new Image();
                testImg.onload = function () {
                    img.src = mobileSrc;
                };
                testImg.src = mobileSrc;
            }
        });

        // Optimize scroll performance
        let ticking = false;
        let lastScrollY = window.scrollY;

        window.addEventListener("scroll", function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    // Hide/show header on scroll
                    const currentScrollY = window.scrollY;
                    const header = document.querySelector(".navbar");

                    if (header) {
                        if (
                            currentScrollY > lastScrollY &&
                            currentScrollY > 100
                        ) {
                            // Scrolling down, hide header
                            header.classList.add("navbar-hidden");
                        } else {
                            // Scrolling up, show header
                            header.classList.remove("navbar-hidden");
                        }
                    }

                    lastScrollY = currentScrollY;
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Fix for iOS 100vh issue
        const fixIOSHeight = () => {
            document.documentElement.style.setProperty(
                "--vh",
                `${window.innerHeight * 0.01}px`
            );

            // Apply the height to elements with vh-100 class
            document.querySelectorAll(".vh-100").forEach((el) => {
                el.style.height = `${window.innerHeight}px`;
            });
        };

        fixIOSHeight();
        window.addEventListener("resize", fixIOSHeight);
        window.addEventListener("orientationchange", fixIOSHeight);

        // Add swipe functionality for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        // Function to handle swipe
        function handleSwipe() {
            const swipeThreshold = 100; // Minimum distance for swipe
            const swipeDistance = touchEndX - touchStartX;

            if (Math.abs(swipeDistance) > swipeThreshold) {
                if (swipeDistance > 0) {
                    // Swipe right
                    console.log("Swipe right detected");
                    // Add your swipe right action here
                } else {
                    // Swipe left
                    console.log("Swipe left detected");
                    // Add your swipe left action here
                }
            }
        }

        // Add touch event listeners
        document.addEventListener(
            "touchstart",
            (e) => {
                touchStartX = e.changedTouches[0].screenX;
            },
            false
        );

        document.addEventListener(
            "touchend",
            (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            },
            false
        );

        // Optimize package cards for mobile
        document.querySelectorAll(".package-card").forEach((card) => {
            // Make entire card clickable
            const cardLink = card.querySelector("a.btn");
            if (cardLink) {
                const href = cardLink.getAttribute("href");

                card.addEventListener("click", function (e) {
                    // Don't trigger if clicking on a button or link inside the card
                    if (!e.target.closest("a, button")) {
                        window.location.href = href;
                    }
                });

                // Add visual feedback
                card.style.cursor = "pointer";
            }
        });

        // Add pull-to-refresh functionality
        let pullStartY = 0;
        let pullMoveY = 0;
        const pullThreshold = 80;
        const pullIndicator = document.createElement("div");

        pullIndicator.className = "pull-to-refresh-indicator";
        pullIndicator.innerHTML = '<i class="fas fa-sync-alt"></i>';
        pullIndicator.style.position = "fixed";
        pullIndicator.style.top = "0";
        pullIndicator.style.left = "50%";
        pullIndicator.style.transform = "translateX(-50%) translateY(-100%)";
        pullIndicator.style.padding = "10px 20px";
        pullIndicator.style.backgroundColor = "rgba(67, 97, 238, 0.9)";
        pullIndicator.style.color = "white";
        pullIndicator.style.borderRadius = "0 0 20px 20px";
        pullIndicator.style.transition = "transform 0.3s ease";
        pullIndicator.style.zIndex = "9999";
        pullIndicator.style.display = "none";

        document.body.appendChild(pullIndicator);

        document.addEventListener("touchstart", (e) => {
            if (window.scrollY === 0) {
                pullStartY = e.touches[0].clientY;
                pullIndicator.style.display = "block";
            }
        });

        document.addEventListener("touchmove", (e) => {
            if (pullStartY > 0) {
                pullMoveY = e.touches[0].clientY - pullStartY;

                if (pullMoveY > 0 && pullMoveY < 200) {
                    pullIndicator.style.transform = `translateX(-50%) translateY(${
                        pullMoveY - 100
                    }px)`;

                    if (pullMoveY > pullThreshold) {
                        pullIndicator.innerHTML =
                            '<i class="fas fa-sync-alt fa-spin"></i> Thả để làm mới';
                    } else {
                        pullIndicator.innerHTML =
                            '<i class="fas fa-sync-alt"></i> Kéo để làm mới';
                    }

                    // Prevent default scrolling
                    e.preventDefault();
                }
            }
        });

        document.addEventListener("touchend", (e) => {
            if (pullStartY > 0 && pullMoveY > pullThreshold) {
                // Show loading indicator
                pullIndicator.innerHTML =
                    '<i class="fas fa-sync-alt fa-spin"></i> Đang làm mới...';
                pullIndicator.style.transform =
                    "translateX(-50%) translateY(0)";

                // Reload the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                // Reset indicator position
                pullIndicator.style.transform =
                    "translateX(-50%) translateY(-100%)";
                setTimeout(() => {
                    pullIndicator.style.display = "none";
                }, 300);
            }

            // Reset values
            pullStartY = 0;
            pullMoveY = 0;
        });
    }

    // Handle touch events for better mobile experience
    document
        .querySelectorAll(".btn, .nav-link, .package-card")
        .forEach((el) => {
            el.addEventListener("touchstart", function () {
                this.classList.add("touch-active");
            });

            el.addEventListener("touchend", function () {
                this.classList.remove("touch-active");
            });
        });

    // Optimize mobile menu
    const navbarToggler = document.querySelector(".navbar-toggler");
    const navbarCollapse = document.querySelector(".navbar-collapse");

    if (navbarToggler && navbarCollapse) {
        // Close mobile menu when clicking outside
        document.addEventListener("click", function (event) {
            const isClickInside =
                navbarToggler.contains(event.target) ||
                navbarCollapse.contains(event.target);

            if (!isClickInside && navbarCollapse.classList.contains("show")) {
                navbarToggler.click();
            }
        });

        // Close mobile menu when clicking on a nav link
        document.querySelectorAll(".navbar-nav .nav-link").forEach((link) => {
            link.addEventListener("click", function () {
                if (navbarCollapse.classList.contains("show")) {
                    navbarToggler.click();
                }
            });
        });

        // Add animation to mobile menu
        navbarToggler.addEventListener("click", function () {
            if (!navbarCollapse.classList.contains("show")) {
                navbarCollapse.style.display = "block";
                setTimeout(() => {
                    navbarCollapse.style.opacity = "1";
                    navbarCollapse.style.transform = "translateY(0)";
                }, 10);
            } else {
                navbarCollapse.style.opacity = "0";
                navbarCollapse.style.transform = "translateY(-10px)";
                setTimeout(() => {
                    navbarCollapse.style.display = "none";
                }, 300);
            }
        });
    }

    // Handle orientation change
    window.addEventListener("orientationchange", function () {
        // Perform adjustments when orientation changes
        setTimeout(() => {
            window.scrollTo(0, 0);

            // Re-apply iOS height fix
            if (isIOS()) {
                document.documentElement.style.setProperty(
                    "--vh",
                    `${window.innerHeight * 0.01}px`
                );
            }

            // Adjust layout for landscape/portrait
            if (window.orientation === 90 || window.orientation === -90) {
                // Landscape mode
                document.body.classList.add("landscape");
                document.body.classList.remove("portrait");
            } else {
                // Portrait mode
                document.body.classList.add("portrait");
                document.body.classList.remove("landscape");
            }
        }, 100);
    });

    // Add double-tap to zoom prevention
    document.addEventListener(
        "dblclick",
        function (e) {
            e.preventDefault();
        },
        { passive: false }
    );

    // Add fast-click for mobile
    if (isMobile()) {
        // Remove 300ms delay on mobile browsers
        document.addEventListener("touchstart", function () {}, {
            passive: true,
        });
    }
});
