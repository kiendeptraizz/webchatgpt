<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class CheckPendingSubscriptions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            // Đếm số đơn hàng đang chờ xử lý
            $pendingSubscriptionsCount = Subscription::where('active', false)
                ->where('payment_status', 'pending')
                ->count();
            
            // Chia sẻ biến với tất cả view
            View::share('pendingSubscriptionsCount', $pendingSubscriptionsCount);
        }
        
        return $next($request);
    }
}
