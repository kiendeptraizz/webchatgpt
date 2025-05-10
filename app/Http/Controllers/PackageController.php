<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Hiển thị danh sách các gói dịch vụ.
     */
    public function index(): View
    {
        // Lấy tất cả các danh mục cha đang hoạt động và danh mục con của chúng
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->with(['packages' => function ($query) {
                $query->where('is_combo', false)->with('promotions');
            }, 'children' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            }, 'children.packages' => function ($query) {
                $query->where('is_combo', false)->with('promotions');
            }, 'parent'])
            ->get();

        // Lấy các gói combo riêng biệt với khuyến mãi
        $combos = Package::where('is_combo', true)->with('promotions')->get();

        // Lấy các khuyến mãi đang hoạt động
        $activePromotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        // Giữ lại các biến cũ để tránh lỗi trong quá trình chuyển đổi
        $aiCreativePersonal = Package::where('category_group', 'ai_creative')
            ->where('is_shared', false)
            ->where('is_combo', false)
            ->with('promotions')
            ->get();

        $aiCreativeShared = Package::where('category_group', 'ai_creative')
            ->where('is_shared', true)
            ->where('is_combo', false)
            ->with('promotions')
            ->get();

        $entertainment = Package::where('category_group', 'entertainment')
            ->where('is_combo', false)
            ->with('promotions')
            ->get();

        return view('home', compact('categories', 'combos', 'aiCreativePersonal', 'aiCreativeShared', 'entertainment', 'activePromotions'));
    }

    /**
     * Hiển thị chi tiết một gói dịch vụ.
     */
    public function show(string $id): View
    {
        $package = Package::with('promotions')->findOrFail($id);

        // Lấy khuyến mãi đang hoạt động cho gói dịch vụ này
        $activePromotion = $package->getActivePromotion();

        // Tính giá sau khuyến mãi
        $discountedPrice = $package->getDiscountedPrice();

        return view('package_detail', compact('package', 'activePromotion', 'discountedPrice'));
    }
}
