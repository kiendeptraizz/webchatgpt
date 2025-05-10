<?php

namespace App\Http\Controllers;

use App\Models\ReferralCommission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReferralController extends Controller
{
    /**
     * Hiển thị trang quản lý giới thiệu
     */
    public function index(): View
    {
        $user = Auth::user();

        // Lấy danh sách người dùng đã được giới thiệu
        $referrals = User::where('referred_by', $user->id)->get();

        // Lấy danh sách hoa hồng
        $commissions = ReferralCommission::where('referrer_id', $user->id)
            ->with(['referred', 'subscription.package'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Tính tổng phần thưởng (thời gian đã nhận và đang chờ)
        $totalDaysReceived = $commissions->where('status', 'paid')
            ->where('reward_type', 'extension')
            ->sum('reward_days');

        $pendingDays = $commissions->where('status', 'pending')
            ->where('reward_type', 'extension')
            ->sum('reward_days');

        // Giữ lại biến cũ để tránh lỗi
        $totalCommission = 0;
        $pendingCommission = 0;

        return view('referrals.index', compact(
            'user',
            'referrals',
            'commissions',
            'totalCommission',
            'pendingCommission',
            'totalDaysReceived',
            'pendingDays'
        ));
    }

    /**
     * Tạo liên kết giới thiệu
     */
    public function generateLink(Request $request)
    {
        $user = Auth::user();

        if (!$user->referral_code) {
            // Tạo mã giới thiệu nếu chưa có
            $user->referral_code = $this->generateUniqueReferralCode();
            $user->save();
        }

        $referralLink = route('register') . '?ref=' . $user->referral_code;

        return response()->json([
            'success' => true,
            'referral_code' => $user->referral_code,
            'referral_link' => $referralLink
        ]);
    }

    /**
     * Tạo mã giới thiệu ngẫu nhiên và đảm bảo tính duy nhất
     */
    private function generateUniqueReferralCode($length = 8)
    {
        do {
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, $length));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}
