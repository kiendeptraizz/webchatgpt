<?php

namespace App\Http\Middleware;

use App\Models\Message;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class CheckUnreadAdminMessages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            // Đếm số tin nhắn chưa đọc từ người dùng
            $unreadAdminMessagesCount = Message::where('is_from_admin', false)
                ->where('is_read', false)
                ->count();
            
            // Chia sẻ biến với tất cả view
            View::share('unreadAdminMessagesCount', $unreadAdminMessagesCount);
        }
        
        return $next($request);
    }
}
