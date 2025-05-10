<?php

namespace App\Http\Middleware;

use App\Models\Message;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class CheckUnreadMessages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Đếm số tin nhắn chưa đọc từ admin
            $unreadMessagesCount = Message::where('user_id', $user->id)
                ->where('is_from_admin', true)
                ->where('is_read', false)
                ->count();
            
            // Chia sẻ biến với tất cả view
            View::share('unreadMessagesCount', $unreadMessagesCount);
        }
        
        return $next($request);
    }
}
