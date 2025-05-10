<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Tạo mã giới thiệu ngẫu nhiên và đảm bảo tính duy nhất
     */
    private function generateUniqueReferralCode($length = 8)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
    /**
     * Hiển thị form đăng nhập.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            // Kiểm tra nếu có redirect_after_login trong session
            if ($request->session()->has('redirect_after_login')) {
                $redirectUrl = $request->session()->get('redirect_after_login');
                $request->session()->forget('redirect_after_login');
                return redirect($redirectUrl);
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput($request->except('password'));
    }

    /**
     * Hiển thị form đăng ký.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ]);

        // Tạo mã giới thiệu ngẫu nhiên
        $referralCode = $this->generateUniqueReferralCode(8);

        // Tìm người giới thiệu (nếu có)
        $referrerId = null;
        $referrer = null;
        if ($request->filled('referral_code')) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                $referrerId = $referrer->id;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Mặc định là người dùng thường
            'referral_code' => $referralCode,
            'referred_by' => $referrerId,
        ]);

        // Nếu có người giới thiệu, tạo bản ghi ReferralCommission
        if ($referrer && $referrer->id != $user->id) {
            // Kiểm tra xem người giới thiệu có gói đăng ký đang hoạt động không
            $referrerSubscription = \App\Models\Subscription::where('user_id', $referrer->id)
                ->where('active', true)
                ->orderBy('end_date', 'desc')
                ->first();

            if ($referrerSubscription) {
                // Tạo bản ghi hoa hồng với phần thưởng là gia hạn thời gian
                \App\Models\ReferralCommission::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $user->id,
                    'subscription_id' => $referrerSubscription->id,
                    'amount' => 0,
                    'status' => 'pending',
                    'reward_type' => 'extension', // Loại phần thưởng là gia hạn thời gian
                    'reward_days' => 7, // Tặng thêm 7 ngày (1 tuần)
                ]);
            }
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Đăng xuất người dùng.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
