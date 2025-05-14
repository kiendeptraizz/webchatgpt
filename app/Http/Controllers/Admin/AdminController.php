<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\ReferralCommission;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Hiển thị trang dashboard của admin với thống kê.
     */
    public function dashboard(): View
    {
        // Thống kê người dùng
        $totalUsers = User::count();
        $newUsersThisWeek = User::where('created_at', '>=', Carbon::now()->subWeek())->count();

        // Thống kê gói dịch vụ
        $totalPackages = Package::count();

        // Thống kê đăng ký
        $totalSubscriptions = Subscription::count();
        $activeSubscriptions = Subscription::where('active', true)->count();

        // Tính toán doanh thu từ dữ liệu thực tế
        $totalRevenue = Subscription::where('active', true)
            ->with('package')
            ->get()
            ->sum(function ($subscription) {
                return $subscription->package ? $subscription->package->price : 0;
            });

        $weeklyRevenue = Subscription::where('active', true)
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->with('package')
            ->get()
            ->sum(function ($subscription) {
                return $subscription->package ? $subscription->package->price : 0;
            });

        // Tính lợi nhuận
        $totalCost = \App\Models\Account::sum('cost_price') ?: 0;
        $totalProfit = $totalRevenue - $totalCost;

        // Số tài khoản đã bán
        $accountsSold = \App\Models\Account::count();

        // Số người mua (số subscription đã kích hoạt)
        $totalBuyers = $activeSubscriptions;

        // Tính phần trăm gói dịch vụ
        $basicPackageCount = Subscription::where('active', true)
            ->whereHas('package', function ($query) {
                $query->where('price', '<', 100000);
            })
            ->count();

        $advancedPackageCount = Subscription::where('active', true)
            ->whereHas('package', function ($query) {
                $query->where('price', '>=', 100000);
            })
            ->count();

        $totalPackageCount = $basicPackageCount + $advancedPackageCount;

        $basicPackagePercent = $totalPackageCount > 0 ? round(($basicPackageCount / $totalPackageCount) * 100) : 0;
        $advancedPackagePercent = $totalPackageCount > 0 ? round(($advancedPackageCount / $totalPackageCount) * 100) : 0;

        // Tính doanh thu theo ngày trong tuần qua
        $revenueData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->startOfDay();
            $nextDate = Carbon::now()->subDays($i)->endOfDay();

            $dailyRevenue = Subscription::where('active', true)
                ->whereBetween('created_at', [$date, $nextDate])
                ->with('package')
                ->get()
                ->sum(function ($subscription) {
                    return $subscription->package ? $subscription->package->price : 0;
                });

            $revenueData[] = $dailyRevenue;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'newUsersThisWeek',
            'totalPackages',
            'totalSubscriptions',
            'activeSubscriptions',
            'weeklyRevenue',
            'totalRevenue',
            'totalCost',
            'totalProfit',
            'accountsSold',
            'totalBuyers',
            'revenueData',
            'basicPackagePercent',
            'advancedPackagePercent'
        ));
    }

    /**
     * Hiển thị danh sách người dùng.
     */
    public function users(): View
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Lưu người dùng mới.
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Người dùng đã được tạo thành công.');
    }

    /**
     * Cập nhật thông tin người dùng.
     */
    public function updateUser(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')
            ->with('success', 'Thông tin người dùng đã được cập nhật.');
    }

    /**
     * Xóa người dùng.
     */
    public function destroyUser($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'Người dùng đã được xóa thành công.');
    }

    /**
     * Hiển thị danh sách gói dịch vụ.
     */
    public function packages(): View
    {
        $packages = Package::with('subscriptions')->get();
        $categories = Category::with(['children', 'packages'])
            ->orderBy('order')
            ->get();
        return view('admin.packages', compact('packages', 'categories'));
    }

    /**
     * Lưu gói dịch vụ mới.
     */
    public function storePackage(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'max_users' => 'required|integer|min:1',
            'features' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'is_shared' => 'boolean',
            'is_combo' => 'boolean',
        ]);

        // Chuyển đổi features từ textarea thành mảng
        $features = array_filter(explode("\n", $request->features));

        // Debug thông tin
        \Illuminate\Support\Facades\Log::info('Package Create Debug', [
            'name' => $request->name,
            'is_shared_checkbox' => $request->has('is_shared'),
            'is_combo_checkbox' => $request->has('is_combo'),
            'all_data' => $request->all()
        ]);

        Package::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'max_users' => $request->max_users,
            'features' => json_encode($features),
            'category_id' => $request->category_id,
            'is_shared' => $request->has('is_shared') ? true : false,
            'is_combo' => $request->has('is_combo') ? true : false,
        ]);

        return redirect()->route('admin.packages')
            ->with('success', 'Gói dịch vụ đã được tạo thành công.');
    }

    /**
     * Cập nhật gói dịch vụ.
     */
    public function updatePackage(Request $request, $id): RedirectResponse
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'max_users' => 'required|integer|min:1',
            'features' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'is_shared' => 'boolean',
            'is_combo' => 'boolean',
        ]);

        // Chuyển đổi features từ textarea thành mảng
        $features = array_filter(explode("\n", $request->features));

        // Debug thông tin
        \Illuminate\Support\Facades\Log::info('Package Update Debug', [
            'id' => $id,
            'name' => $request->name,
            'is_shared_checkbox' => $request->has('is_shared'),
            'is_combo_checkbox' => $request->has('is_combo'),
            'all_data' => $request->all()
        ]);

        $package->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'max_users' => $request->max_users,
            'features' => json_encode($features),
            'category_id' => $request->category_id,
            'is_shared' => $request->has('is_shared') ? true : false,
            'is_combo' => $request->has('is_combo') ? true : false,
        ]);

        return redirect()->route('admin.packages')
            ->with('success', 'Gói dịch vụ đã được cập nhật.')
            ->with('edited_package_id', $id);
    }

    /**
     * Xóa gói dịch vụ.
     */
    public function destroyPackage($id): RedirectResponse
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.packages')
            ->with('success', 'Gói dịch vụ đã được xóa thành công.');
    }

    /**
     * Hiển thị danh sách đăng ký gói dịch vụ.
     */
    public function subscriptions(): View
    {
        $subscriptions = Subscription::with(['user', 'package'])->get();
        return view('admin.subscriptions', compact('subscriptions'));
    }

    /**
     * Kích hoạt đăng ký.
     */
    public function activateSubscription($id): RedirectResponse
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update(['active' => true]);

        // Kiểm tra xem có phần thưởng giới thiệu nào cần xử lý không
        $commission = ReferralCommission::where('subscription_id', $subscription->id)
            ->where('status', 'pending')
            ->where('reward_type', 'extension')
            ->first();

        if ($commission) {
            // Tìm subscription của người giới thiệu
            $referrerSubscription = Subscription::where('user_id', $commission->referrer_id)
                ->where('active', true)
                ->orderBy('end_date', 'desc')
                ->first();

            if ($referrerSubscription) {
                // Gia hạn thêm số ngày được thưởng
                $currentEndDate = $referrerSubscription->end_date;
                $newEndDate = $currentEndDate->copy()->addDays($commission->reward_days);

                // Log thông tin để debug
                \Illuminate\Support\Facades\Log::info('Referral Reward Debug (Admin)', [
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
            }
        }

        return redirect()->route('admin.subscriptions')
            ->with('success', 'Đăng ký đã được kích hoạt thành công.');
    }

    /**
     * Xóa đăng ký.
     */
    public function destroySubscription($id): RedirectResponse
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('admin.subscriptions')
            ->with('success', 'Đăng ký đã được xóa thành công.');
    }
}
