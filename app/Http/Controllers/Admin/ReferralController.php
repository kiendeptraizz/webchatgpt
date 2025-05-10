<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Hiển thị trang quản lý giới thiệu
     */
    public function index()
    {
        $commissions = \App\Models\ReferralCommission::with(['referrer', 'referred', 'subscription.package'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.referrals.index', compact('commissions'));
    }

    /**
     * Phê duyệt hoa hồng giới thiệu
     */
    public function approve($id)
    {
        $commission = \App\Models\ReferralCommission::findOrFail($id);

        if ($commission->status != 'pending') {
            return redirect()->route('admin.referrals')
                ->with('error', 'Hoa hồng này đã được xử lý trước đó.');
        }

        // Xử lý phần thưởng dựa trên loại
        if ($commission->reward_type == 'extension') {
            // Tìm subscription của người giới thiệu
            $referrerSubscription = \App\Models\Subscription::where('user_id', $commission->referrer_id)
                ->where('active', true)
                ->orderBy('end_date', 'desc')
                ->first();

            if ($referrerSubscription) {
                // Gia hạn thêm số ngày được thưởng
                $currentEndDate = $referrerSubscription->end_date;
                $newEndDate = $currentEndDate->copy()->addDays($commission->reward_days);

                // Log thông tin để debug
                \Illuminate\Support\Facades\Log::info('Referral Reward Debug', [
                    'commission_id' => $commission->id,
                    'referrer_id' => $commission->referrer_id,
                    'referrer_name' => $commission->referrer->name,
                    'subscription_id' => $referrerSubscription->id,
                    'current_end_date' => $currentEndDate->format('Y-m-d H:i:s'),
                    'new_end_date' => $newEndDate->format('Y-m-d H:i:s'),
                    'reward_days' => $commission->reward_days
                ]);

                $referrerSubscription->end_date = $newEndDate;
                $referrerSubscription->save();

                // Cập nhật trạng thái hoa hồng
                $commission->update(['status' => 'paid', 'paid_at' => now()]);

                return redirect()->route('admin.referrals')
                    ->with('success', 'Đã gia hạn thêm ' . $commission->reward_days . ' ngày cho người giới thiệu.');
            } else {
                return redirect()->route('admin.referrals')
                    ->with('error', 'Không tìm thấy gói đăng ký nào của người giới thiệu để gia hạn.');
            }
        } else {
            // Xử lý hoa hồng tiền mặt (nếu có)
            $commission->update(['status' => 'paid', 'paid_at' => now()]);

            return redirect()->route('admin.referrals')
                ->with('success', 'Đã phê duyệt hoa hồng thành công.');
        }
    }
}
