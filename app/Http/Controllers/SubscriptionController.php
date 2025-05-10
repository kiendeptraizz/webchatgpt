<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Promotion;
use App\Models\ReferralCommission;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Tính toán số tiền hoa hồng dựa trên giá gói và thời hạn
     * Mặc định là 10% giá trị đơn hàng
     */
    private function calculateCommissionAmount($price, $duration): float
    {
        // Tính tổng tiền đơn hàng
        $totalAmount = $this->calculateTotalAmount($price, $duration);

        // Tính hoa hồng (10%)
        return $totalAmount * 0.1;
    }
    /**
     * Tính tổng tiền dựa trên giá gói và thời hạn đăng ký
     *
     * @param float $price Giá gói dịch vụ
     * @param int $duration Thời hạn đăng ký (tháng)
     * @param Promotion|null $promotion Khuyến mãi áp dụng (nếu có)
     * @return float Tổng tiền sau khi áp dụng giảm giá theo thời hạn và khuyến mãi
     */
    private function calculateTotalAmount(float $price, int $duration, ?Promotion $promotion = null): float
    {
        // Tính giá theo thời hạn đăng ký
        $totalBeforePromotion = 0;
        switch ($duration) {
            case 3:
                // Giảm 10% cho gói 3 tháng
                $totalBeforePromotion = $price * 3 * 0.9;
                break;
            case 6:
                // Giảm 20% cho gói 6 tháng
                $totalBeforePromotion = $price * 6 * 0.8;
                break;
            default:
                $totalBeforePromotion = $price * $duration;
                break;
        }

        // Áp dụng khuyến mãi nếu có
        if ($promotion && $promotion->isValid()) {
            $discount = $promotion->calculateDiscount($totalBeforePromotion);
            return max(0, $totalBeforePromotion - $discount);
        }

        return $totalBeforePromotion;
    }

    /**
     * Lưu thông tin đăng ký gói dịch vụ.
     */
    public function store(Request $request): RedirectResponse
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để đăng ký gói dịch vụ.')
                ->with('redirect_after_login', route('packages.show', $request->package_id));
        }

        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'duration' => 'required|in:1,3,6',
            'email' => 'required|email',
            'phone' => 'required|string|min:10|max:15',
        ]);

        // Tính ngày kết thúc dựa trên số tháng đăng ký
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonths((int)$request->duration);

        // Tạo bản ghi đăng ký mới
        $subscription = Subscription::create([
            'user_id' => Auth::id(), // Người dùng đã đăng nhập
            'package_id' => $request->package_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'active' => false,
            'payment_proof' => null,
            'payment_status' => 'pending',
            'phone' => $request->phone,
        ]);

        // Lấy thông tin gói dịch vụ và khuyến mãi
        $package = Package::with('promotions')->findOrFail($request->package_id);

        // Lấy khuyến mãi đang hoạt động cho gói dịch vụ này
        $activePromotion = $package->getActivePromotion();

        // Áp dụng mã khuyến mãi nếu có
        $promotionCode = $request->input('promotion_code');
        if ($promotionCode) {
            $codePromotion = Promotion::where('code', $promotionCode)
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            // Nếu tìm thấy mã khuyến mãi hợp lệ và có giá trị giảm giá cao hơn khuyến mãi hiện tại
            if ($codePromotion && $codePromotion->isValid()) {
                if (
                    !$activePromotion ||
                    ($codePromotion->discount_type == 'percentage' && $codePromotion->discount_value > $activePromotion->discount_value) ||
                    ($codePromotion->discount_type == 'fixed_amount' && $codePromotion->discount_value > $activePromotion->discount_value)
                ) {
                    $activePromotion = $codePromotion;

                    // Tăng số lần sử dụng của mã khuyến mãi
                    $codePromotion->increment('used_count');
                }
            }
        }

        // Tính tổng tiền dựa trên thời hạn đăng ký và khuyến mãi
        $total_amount = $this->calculateTotalAmount($package->price, (int)$request->duration, $activePromotion);

        // Chuyển hướng đến trang thanh toán
        return redirect()->route('payment.show', [
            'id' => $subscription->id,
            'email' => $request->email,
            'phone' => $request->phone,
            'duration' => $request->duration,
            'total_amount' => $total_amount,
            'promotion_id' => $activePromotion ? $activePromotion->id : null,
        ]);
    }
    /**
     * Hiển thị trang thanh toán
     */
    public function showPayment(Request $request, $id): View
    {
        $subscription = Subscription::with('package')->findOrFail($id);
        $email = $request->query('email');
        $phone = $request->query('phone');
        $duration = $request->query('duration');
        $total_amount = $request->query('total_amount');
        $promotion_id = $request->query('promotion_id');

        // Lấy thông tin khuyến mãi nếu có
        $promotion = null;
        if ($promotion_id) {
            $promotion = Promotion::find($promotion_id);
        }

        // Tính giá gốc trước khuyến mãi
        $originalPrice = 0;
        switch ((int)$duration) {
            case 3:
                $originalPrice = $subscription->package->price * 3 * 0.9;
                break;
            case 6:
                $originalPrice = $subscription->package->price * 6 * 0.8;
                break;
            default:
                $originalPrice = $subscription->package->price * (int)$duration;
                break;
        }

        // Tính số tiền được giảm
        $discountAmount = $originalPrice - (float)$total_amount;

        return view('payment', compact('subscription', 'email', 'phone', 'duration', 'total_amount', 'promotion', 'originalPrice', 'discountAmount'));
    }

    /**
     * Xử lý thanh toán
     */
    public function processPayment(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,momo',
            'payment_proof' => 'required|image|max:5120', // 5MB max
            'payment_notes' => 'nullable|string|max:500',
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ]);

        $subscription = Subscription::findOrFail($id);
        $user = $subscription->user;

        // Xử lý mã giới thiệu nếu có
        if ($request->filled('referral_code') && empty($user->referred_by)) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if ($referrer && $referrer->id != $user->id) {
                $user->update(['referred_by' => $referrer->id]);

                // Tạo bản ghi hoa hồng với số tiền 0 (thay vì tiền, sẽ tặng thêm thời gian sử dụng)
                ReferralCommission::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'amount' => 0,
                    'status' => 'pending',
                    'reward_type' => 'extension', // Loại phần thưởng là gia hạn thời gian
                    'reward_days' => 7, // Tặng thêm 7 ngày (1 tuần)
                ]);
            }
        }
        // Nếu người dùng đã có người giới thiệu nhưng chưa có bản ghi hoa hồng
        elseif (!empty($user->referred_by)) {
            $referrer = User::find($user->referred_by);
            if ($referrer && $referrer->id != $user->id) {
                // Kiểm tra xem đã có bản ghi hoa hồng cho người giới thiệu này chưa
                $existingCommission = ReferralCommission::where('referrer_id', $referrer->id)
                    ->where('referred_id', $user->id)
                    ->first();

                if (!$existingCommission) {
                    // Tạo bản ghi hoa hồng với phần thưởng là gia hạn thời gian
                    ReferralCommission::create([
                        'referrer_id' => $referrer->id,
                        'referred_id' => $user->id,
                        'subscription_id' => $subscription->id,
                        'amount' => 0,
                        'status' => 'pending',
                        'reward_type' => 'extension', // Loại phần thưởng là gia hạn thời gian
                        'reward_days' => 7, // Tặng thêm 7 ngày (1 tuần)
                    ]);
                }
            }
        }

        // Xử lý tải lên bằng chứng thanh toán
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

            // Cập nhật thông tin thanh toán
            $subscription->update([
                'payment_proof' => $path,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'payment_notes' => $request->payment_notes,
            ]);
        }

        // Tính tổng tiền dựa trên thời hạn đăng ký
        $duration = Carbon::parse($subscription->end_date)->diffInMonths(Carbon::parse($subscription->start_date));
        $total_amount = $this->calculateTotalAmount($subscription->package->price, $duration);

        return redirect()->route('payment.confirmation', [
            'id' => $subscription->id,
            'total_amount' => $total_amount,
            'duration' => $duration,
        ]);
    }

    /**
     * Hiển thị trang xác nhận thanh toán
     */
    public function showConfirmation(Request $request, $id): View
    {
        $subscription = Subscription::with('package')->findOrFail($id);
        $total_amount = $request->query('total_amount');
        $duration = $request->query('duration');

        return view('payment_confirmation', compact('subscription', 'total_amount', 'duration'));
    }
}
