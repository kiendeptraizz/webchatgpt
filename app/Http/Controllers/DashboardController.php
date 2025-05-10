<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard của người dùng.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Lấy subscription đang hoạt động của người dùng (nếu có)
        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('active', true)
            ->where('end_date', '>', Carbon::now())
            ->with('package')
            ->first();
            
        // Lấy subscription đang chờ duyệt (nếu có)
        $pendingSubscription = Subscription::where('user_id', $user->id)
            ->where('active', false)
            ->where('payment_status', 'pending')
            ->with('package')
            ->first();
            
        // Lấy số lượng chat của người dùng
        $chatCount = Message::where('user_id', $user->id)->count();
        
        // Tính số ngày còn lại của gói dịch vụ
        $daysRemaining = $activeSubscription 
            ? Carbon::now()->diffInDays($activeSubscription->end_date, false) 
            : 0;
            
        // Lấy các chat gần đây
        $recentChats = Message::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });
        
        return view('dashboard.index', compact(
            'user', 
            'activeSubscription', 
            'pendingSubscription',
            'chatCount', 
            'daysRemaining',
            'recentChats'
        ));
    }
}
