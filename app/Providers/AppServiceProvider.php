<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Chia sẻ số tin nhắn chưa đọc và đơn hàng chưa xử lý với tất cả view
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Đếm số tin nhắn chưa đọc từ admin
                $unreadMessagesCount = Message::where('user_id', $user->id)
                    ->where('is_from_admin', true)
                    ->where('is_read', false)
                    ->count();

                $view->with('unreadMessagesCount', $unreadMessagesCount);

                // Nếu là admin, đếm số đơn hàng đang chờ xử lý và tin nhắn chưa đọc
                if ($user->isAdmin()) {
                    $pendingSubscriptionsCount = Subscription::where('active', false)
                        ->where('payment_status', 'pending')
                        ->count();

                    $unreadAdminMessagesCount = Message::where('is_from_admin', false)
                        ->where('is_read', false)
                        ->count();

                    $view->with('pendingSubscriptionsCount', $pendingSubscriptionsCount);
                    $view->with('unreadAdminMessagesCount', $unreadAdminMessagesCount);
                }
            }
        });
    }
}
