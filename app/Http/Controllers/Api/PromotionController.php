<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Promotion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Kiểm tra mã khuyến mãi
     */
    public function checkPromotion(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
            'package_id' => 'nullable|exists:packages,id',
        ]);

        $code = strtoupper($request->code);
        $packageId = $request->package_id;

        // Tìm khuyến mãi theo mã
        $promotion = Promotion::where('code', $code)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$promotion) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn',
            ]);
        }

        // Kiểm tra giới hạn sử dụng
        if ($promotion->usage_limit !== null && $promotion->used_count >= $promotion->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi đã hết lượt sử dụng',
            ]);
        }

        // Kiểm tra xem khuyến mãi có áp dụng cho gói dịch vụ này không
        if ($packageId) {
            $package = Package::find($packageId);

            // Nếu khuyến mãi có gói dịch vụ cụ thể và gói hiện tại không nằm trong danh sách
            if ($promotion->packages->count() > 0 && !$promotion->packages->contains($packageId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã khuyến mãi không áp dụng cho gói dịch vụ này',
                ]);
            }

            // Tính toán giá trị giảm giá
            $originalPrice = $package->price;
            $discount = $promotion->calculateDiscount($originalPrice);
            $discountedPrice = max(0, $originalPrice - $discount);

            return response()->json([
                'success' => true,
                'message' => 'Mã khuyến mãi hợp lệ',
                'promotion' => [
                    'name' => $promotion->name,
                    'code' => $promotion->code,
                    'discount_type' => $promotion->discount_type,
                    'discount_value' => $promotion->discount_value,
                    'discount_amount' => $discount,
                    'original_price' => $originalPrice,
                    'discounted_price' => $discountedPrice,
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mã khuyến mãi hợp lệ',
            'promotion' => [
                'name' => $promotion->name,
                'code' => $promotion->code,
                'discount_type' => $promotion->discount_type,
                'discount_value' => $promotion->discount_value,
            ],
        ]);
    }
}
