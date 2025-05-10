/**
 * Mobile features for Trung Kiên Unlock
 * This file contains additional mobile-specific features
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

    // Only run on mobile devices
    if (!isMobile()) return;

    // Add ripple effect to package cards
    document.querySelectorAll(".package-card").forEach((card) => {
        card.classList.add("ripple");

        card.addEventListener("click", function (e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement("div");
            ripple.classList.add("ripple-effect");
            ripple.style.top = y + "px";
            ripple.style.left = x + "px";

            card.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add swipe indicator to package sections
    const packageSections = document.querySelectorAll(
        "#packages > .container > div.mb-5"
    );

    packageSections.forEach((section) => {
        const packages = section.querySelectorAll(".package-card");

        if (packages.length > 1) {
            const swipeIndicator = document.createElement("div");
            swipeIndicator.className = "swipe-indicator";

            for (let i = 0; i < packages.length; i++) {
                const dot = document.createElement("div");
                dot.className = "dot";
                if (i === 0) dot.classList.add("active");
                swipeIndicator.appendChild(dot);
            }

            section.appendChild(swipeIndicator);
        }
    });

    // Hide some features on very small screens
    if (window.innerWidth < 375) {
        document.querySelectorAll(".feature-list").forEach((list) => {
            const items = list.querySelectorAll("li");

            if (items.length > 4) {
                // Hide items after the 4th one
                for (let i = 4; i < items.length; i++) {
                    items[i].classList.add("mobile-hidden");
                }

                // Add "show more" button
                const showMore = document.createElement("div");
                showMore.className = "show-more-features";
                showMore.textContent = "Xem thêm tính năng";
                showMore.addEventListener("click", function () {
                    list.querySelectorAll("li.mobile-hidden").forEach(
                        (item) => {
                            item.classList.remove("mobile-hidden");
                        }
                    );
                    showMore.style.display = "none";
                });

                list.parentNode.insertBefore(showMore, list.nextSibling);
            }
        });
    }

    // Add mobile search toggle
    const navbar = document.querySelector(".navbar");
    if (navbar) {
        // Create search toggle button
        const searchToggle = document.createElement("button");
        searchToggle.className = "mobile-search-toggle";
        searchToggle.innerHTML = '<i class="fas fa-search"></i>';

        // Create mobile search container
        const searchContainer = document.createElement("div");
        searchContainer.className = "mobile-search-container";
        searchContainer.innerHTML = `
            <form class="mobile-search-form">
                <input type="text" class="mobile-search-input" placeholder="Tìm kiếm gói dịch vụ...">
                <button type="button" class="mobile-search-close"><i class="fas fa-times"></i></button>
            </form>
        `;

        // Add to DOM
        const navbarContainer = navbar.querySelector(".container");
        if (navbarContainer) {
            const navbarBrand = navbarContainer.querySelector(".navbar-brand");
            if (navbarBrand && navbarBrand.parentNode) {
                navbarBrand.parentNode.insertBefore(
                    searchToggle,
                    navbarBrand.nextSibling
                );
                document.body.appendChild(searchContainer);

                // Add event listeners
                searchToggle.addEventListener("click", function () {
                    searchContainer.classList.add("show");
                    searchContainer.querySelector("input").focus();
                });

                searchContainer
                    .querySelector(".mobile-search-close")
                    .addEventListener("click", function () {
                        searchContainer.classList.remove("show");
                    });

                // Handle search functionality
                const searchInput = searchContainer.querySelector("input");
                searchInput.addEventListener("keyup", function (e) {
                    if (e.key === "Enter") {
                        // Get search term
                        const searchTerm = searchInput.value.toLowerCase();

                        // Close search container
                        searchContainer.classList.remove("show");

                        // Scroll to packages section
                        const packagesSection =
                            document.getElementById("packages");
                        if (packagesSection) {
                            packagesSection.scrollIntoView({
                                behavior: "smooth",
                            });

                            // Trigger search functionality
                            const mainSearchInput =
                                document.querySelector(".search-box input");
                            if (mainSearchInput) {
                                mainSearchInput.value = searchTerm;
                                mainSearchInput.dispatchEvent(
                                    new Event("keyup")
                                );
                            }
                        }
                    }
                });
            }
        }
    }

    // Add bottom navigation bar for mobile
    const bottomNav = document.createElement("div");
    bottomNav.className = "mobile-bottom-nav";

    // Kiểm tra xem đang ở trang dashboard hay không
    const isDashboard = window.location.pathname.includes("/dashboard");

    bottomNav.innerHTML = `
        <a href="${
            isDashboard ? "/" : "#"
        }" class="mobile-bottom-nav-item" id="homeNavBtn">
            <i class="fas fa-home"></i>
            <span>Trang chủ</span>
        </a>
        <a href="${
            isDashboard ? "/#packages" : "#packages"
        }" class="mobile-bottom-nav-item" id="packagesNavBtn">
            <i class="fas fa-box"></i>
            <span>Gói dịch vụ</span>
        </a>
        <a href="#" class="mobile-bottom-nav-item" id="mobileSearchBtn">
            <i class="fas fa-search"></i>
            <span>Tìm kiếm</span>
        </a>
        <a href="https://zalo.me/0378059206" target="_blank" class="mobile-bottom-nav-item mobile-chat-btn">
            <i class="fas fa-comment-dots"></i>
            <span>Tư vấn</span>
        </a>
    `;

    document.body.appendChild(bottomNav);

    // Add event listener to mobile search button
    const mobileSearchBtn = document.getElementById("mobileSearchBtn");
    if (mobileSearchBtn) {
        mobileSearchBtn.addEventListener("click", function (e) {
            e.preventDefault();
            const searchToggle = document.querySelector(
                ".mobile-search-toggle"
            );
            if (searchToggle) {
                searchToggle.click();
            }
        });
    }

    // Add event listener to home button
    const homeNavBtn = document.getElementById("homeNavBtn");
    if (homeNavBtn) {
        homeNavBtn.addEventListener("click", function (e) {
            // Nếu đang ở trang dashboard, không cần preventDefault vì cần chuyển về trang chủ
            if (!window.location.pathname.includes("/dashboard")) {
                e.preventDefault();
                // Cuộn lên đầu trang nếu đang ở trang chủ
                window.scrollTo({
                    top: 0,
                    behavior: "smooth",
                });
            }
        });
    }

    // Add event listener to packages button
    const packagesNavBtn = document.getElementById("packagesNavBtn");
    if (packagesNavBtn) {
        packagesNavBtn.addEventListener("click", function (e) {
            // Nếu đang ở trang dashboard, không cần preventDefault vì cần chuyển về trang gói dịch vụ
            if (!window.location.pathname.includes("/dashboard")) {
                e.preventDefault();
                // Cuộn đến phần packages
                const packagesSection = document.getElementById("packages");
                if (packagesSection) {
                    packagesSection.scrollIntoView({
                        behavior: "smooth",
                    });
                }
            }
        });
    }

    // Add CSS for bottom navigation
    const style = document.createElement("style");
    style.textContent = `
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background-color: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .mobile-bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #666;
            text-decoration: none;
            font-size: 0.7rem;
            padding: 5px 0;
            width: 25%;
        }

        .mobile-bottom-nav-item i {
            font-size: 1.2rem;
            margin-bottom: 3px;
        }

        .mobile-bottom-nav-item:hover,
        .mobile-bottom-nav-item:active,
        .mobile-bottom-nav-item:focus {
            color: var(--primary-color, #4361ee);
        }

        /* Adjust body padding to account for bottom nav */
        body {
            padding-bottom: 60px;
        }

        /* Style chat support button on mobile */
        @media (max-width: 767.98px) {
            .chat-support-btn {
                bottom: 70px;
                right: 10px;
                width: 50px;
                height: 50px;
                z-index: 999;
            }

            .chat-support-btn .chat-support-tooltip {
                display: none;
            }
        }

        /* Add ripple effect */
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.7);
            width: 100px;
            height: 100px;
            margin-top: -50px;
            margin-left: -50px;
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 0.5;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;

    document.head.appendChild(style);
});
