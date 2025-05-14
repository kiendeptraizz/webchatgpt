@if($package->getActivePromotion())
    @php
        $promotion = $package->getActivePromotion();
        $discountedPrice = $package->getDiscountedPrice();
        $discount = $package->price - $discountedPrice;
        $percentOff = round(($discount / $package->price) * 100);
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const packageCard = document.querySelector('[data-package-id="{{ $package->id }}"]');
            if (packageCard && !packageCard.classList.contains('has-promotion')) {
                packageCard.classList.add('has-promotion');
            }
        });
    </script>
    <div class="promotion-badge">
        @if($promotion->discount_type == 'percentage')
            <span class="badge" style="background-color: #6247aa; font-size: 1rem; padding: 0.5rem 0.75rem; border-radius: 8px;">
                <i class="fas fa-tags me-1"></i> Giảm {{ $promotion->discount_value }}%
            </span>
        @else
            <span class="badge" style="background-color: #6247aa; font-size: 1rem; padding: 0.5rem 0.75rem; border-radius: 8px;">
                <i class="fas fa-tags me-1"></i> Giảm {{ number_format($promotion->discount_value, 0, ',', '.') }}đ
            </span>
        @endif
    </div>
    <div class="price-comparison">
        <span class="original-price" style="font-size: 1.1rem; text-decoration: line-through; color: #888; display: inline-block; margin-bottom: 0.25rem;">{{ number_format($package->price, 0, ',', '.') }}đ</span>
        @if(isset($category) && $category->name == 'GIẢI TRÍ & ĐA PHƯƠNG TIỆN' || isset($childCategory) && $childCategory->name == 'GIẢI TRÍ & ĐA PHƯƠNG TIỆN')
            <span class="discounted-price" style="color: #ff9900; font-size: 2rem; font-weight: 700; display: inline-block;">{{ number_format($discountedPrice, 0, ',', '.') }}đ</span>
        @else
            <span class="discounted-price" style="color: #ffffff; font-size: 2rem; font-weight: 700; display: inline-block; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);">{{ number_format($discountedPrice, 0, ',', '.') }}đ</span>
        @endif
    </div>
@else
    @if(isset($category) && $category->name == 'GIẢI TRÍ & ĐA PHƯƠNG TIỆN' || isset($childCategory) && $childCategory->name == 'GIẢI TRÍ & ĐA PHƯƠNG TIỆN')
        <div class="entertainment-price" style="color: #ff9900; font-size: 2rem; font-weight: 700; display: inline-block;">{{ number_format($package->price, 0, ',', '.') }}đ</div>
    @else
        <div class="package-price" style="color: #ffffff; font-size: 2rem; font-weight: 700; display: inline-block; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);">{{ number_format($package->price, 0, ',', '.') }}đ</div>
    @endif
@endif
