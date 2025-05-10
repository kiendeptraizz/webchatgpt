<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Package;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Xuất báo cáo đăng ký theo khoảng thời gian
     */
    public function exportSubscriptions(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:all,active,pending',
        ]);

        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->subDays(30)->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfDay();

        $status = $request->input('status', 'all');

        $query = Subscription::with(['user', 'package', 'account'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($status === 'active') {
            $query->where('active', true);
        } elseif ($status === 'pending') {
            $query->where('active', false);
        }

        $subscriptions = $query->get();

        // Tính tổng doanh thu
        $totalRevenue = $subscriptions
            ->filter(function ($subscription) {
                return $subscription->active;
            })
            ->sum(function ($subscription) {
                return $subscription->package ? $subscription->package->price : 0;
            });

        // Tính số lượng theo trạng thái
        $activeCount = $subscriptions->where('active', true)->count();
        $pendingCount = $subscriptions->where('active', false)->count();

        // Tính số lượng theo gói dịch vụ
        $packageStats = [];
        foreach (Package::all() as $package) {
            $count = $subscriptions
                ->filter(function ($subscription) use ($package) {
                    return $subscription->package_id === $package->id && $subscription->active;
                })
                ->count();

            $revenue = $subscriptions
                ->filter(function ($subscription) use ($package) {
                    return $subscription->package_id === $package->id && $subscription->active;
                })
                ->count() * $package->price;

            $packageStats[$package->id] = [
                'name' => $package->name,
                'count' => $count,
                'revenue' => $revenue,
            ];
        }

        // Tính số lượng theo phương thức thanh toán
        $paymentMethodStats = [
            'bank_transfer' => [
                'name' => 'Chuyển khoản ngân hàng',
                'count' => $subscriptions->where('payment_method', 'bank_transfer')->where('active', true)->count(),
            ],
            'momo' => [
                'name' => 'Ví MoMo',
                'count' => $subscriptions->where('payment_method', 'momo')->where('active', true)->count(),
            ],
            'zalopay' => [
                'name' => 'Zalo',
                'count' => $subscriptions->where('payment_method', 'zalopay')->where('active', true)->count(),
            ],
            'vnpay' => [
                'name' => 'VNPay',
                'count' => $subscriptions->where('payment_method', 'vnpay')->where('active', true)->count(),
            ],
            'admin_assigned' => [
                'name' => 'Admin gán',
                'count' => $subscriptions->where('payment_method', 'admin_assigned')->where('active', true)->count(),
            ],
            'other' => [
                'name' => 'Khác',
                'count' => $subscriptions->whereNotIn('payment_method', ['bank_transfer', 'momo', 'zalopay', 'vnpay', 'admin_assigned'])->where('active', true)->count(),
            ],
        ];

        return view('admin.reports.subscriptions', compact(
            'subscriptions',
            'startDate',
            'endDate',
            'status',
            'totalRevenue',
            'activeCount',
            'pendingCount',
            'packageStats',
            'paymentMethodStats'
        ));
    }

    /**
     * Xuất báo cáo chi tiết cho một đơn hàng cụ thể
     */
    public function exportSubscriptionDetail($id)
    {
        $subscription = Subscription::with(['user', 'package', 'account'])->findOrFail($id);

        return view('admin.reports.subscription_detail', compact('subscription'));
    }
}
