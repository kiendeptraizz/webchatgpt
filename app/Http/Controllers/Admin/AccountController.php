<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Hiển thị danh sách tài khoản.
     */
    public function index()
    {
        $accounts = \App\Models\Account::withCount(['subscriptions', 'users'])->get();
        return view('admin.accounts.index', compact('accounts'));
    }

    /**
     * Hiển thị form tạo tài khoản mới.
     */
    public function create()
    {
        return view('admin.accounts.create');
    }

    /**
     * Lưu tài khoản mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:accounts',
            'password' => 'required|string|min:6',
            'cost_price' => 'nullable|numeric|min:0',
            'account_type' => 'required|string|in:standard,premium',
            'description' => 'nullable|string',
            'max_users' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        \App\Models\Account::create([
            'username' => $request->username,
            'password' => $request->password,
            'cost_price' => $request->cost_price,
            'account_type' => $request->account_type,
            'description' => $request->description,
            'max_users' => $request->max_users,
            'is_active' => true,
            'current_users' => 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Tài khoản đã được tạo thành công.');
    }

    /**
     * Hiển thị chi tiết tài khoản.
     */
    public function show($id)
    {
        $account = \App\Models\Account::with(['subscriptions.user', 'subscriptions.package'])->findOrFail($id);

        // Lấy danh sách người dùng chưa được gán cho bất kỳ tài khoản nào
        $availableUsers = \App\Models\User::whereDoesntHave('subscriptions', function ($query) {
            $query->whereNotNull('account_id');
        })->get();

        return view('admin.accounts.show', compact('account', 'availableUsers'));
    }

    /**
     * Hiển thị form chỉnh sửa tài khoản.
     */
    public function edit($id)
    {
        $account = \App\Models\Account::findOrFail($id);
        return view('admin.accounts.edit', compact('account'));
    }

    /**
     * Cập nhật thông tin tài khoản.
     */
    public function update(Request $request, $id)
    {
        $account = \App\Models\Account::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:accounts,username,' . $account->id,
            'cost_price' => 'nullable|numeric|min:0',
            'account_type' => 'required|string|in:standard,premium',
            'description' => 'nullable|string',
            'max_users' => 'required|integer|min:' . $account->current_users,
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = [
            'username' => $request->username,
            'cost_price' => $request->cost_price,
            'account_type' => $request->account_type,
            'description' => $request->description,
            'max_users' => $request->max_users,
            'is_active' => $request->has('is_active'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $account->update($data);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Thông tin tài khoản đã được cập nhật.');
    }

    /**
     * Xóa tài khoản.
     */
    public function destroy($id)
    {
        $account = \App\Models\Account::findOrFail($id);

        // Cập nhật các subscription liên quan
        \App\Models\Subscription::where('account_id', $account->id)
            ->update(['account_id' => null]);

        $account->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Tài khoản đã được xóa thành công.');
    }

    /**
     * Gán tài khoản cho subscription.
     */
    public function assignAccount(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'account_id' => 'required|exists:accounts,id',
        ]);

        $subscription = \App\Models\Subscription::findOrFail($request->subscription_id);
        $account = \App\Models\Account::findOrFail($request->account_id);

        // Kiểm tra xem tài khoản có còn slot trống không
        if ($account->current_users >= $account->max_users) {
            return redirect()->back()
                ->with('error', 'Tài khoản đã đạt giới hạn số người dùng.');
        }

        // Nếu subscription đã có account, giảm current_users của account cũ
        if ($subscription->account_id) {
            $oldAccount = \App\Models\Account::find($subscription->account_id);
            if ($oldAccount) {
                $oldAccount->decrement('current_users');
            }
        }

        // Gán account mới và tăng current_users
        $subscription->update(['account_id' => $account->id]);
        $account->increment('current_users');
        $account->update(['last_used_at' => now()]);

        return redirect()->back()
            ->with('success', 'Đã gán tài khoản thành công.');
    }

    /**
     * Gán người dùng vào tài khoản.
     */
    public function assignUser(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $account = \App\Models\Account::findOrFail($request->account_id);
        $user = \App\Models\User::findOrFail($request->user_id);

        // Kiểm tra xem tài khoản có còn slot trống không
        if ($account->current_users >= $account->max_users) {
            return redirect()->back()
                ->with('error', 'Tài khoản đã đạt giới hạn số người dùng.');
        }

        // Kiểm tra xem người dùng đã có subscription chưa
        $existingSubscription = \App\Models\Subscription::where('user_id', $user->id)
            ->where('account_id', $account->id)
            ->first();

        if ($existingSubscription) {
            return redirect()->back()
                ->with('error', 'Người dùng này đã được gán cho tài khoản này.');
        }

        // Tạo subscription mới cho người dùng
        $package = \App\Models\Package::first(); // Lấy gói đầu tiên, có thể thay đổi theo logic của bạn

        if (!$package) {
            return redirect()->back()
                ->with('error', 'Không tìm thấy gói dịch vụ nào.');
        }

        // Tính ngày bắt đầu và kết thúc dựa trên tài khoản
        $startDate = $account->start_date ?? now();
        $endDate = $account->end_date ?? now()->addDays(30); // Mặc định 30 ngày nếu tài khoản không có ngày kết thúc

        \App\Models\Subscription::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'account_id' => $account->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'active' => true,
            'payment_status' => 'completed',
            'payment_method' => 'admin_assigned',
        ]);

        // Tăng số người dùng hiện tại của tài khoản
        $account->increment('current_users');
        $account->update(['last_used_at' => now()]);

        return redirect()->back()
            ->with('success', 'Đã gán người dùng vào tài khoản thành công.');
    }

    /**
     * Hủy gán tài khoản cho subscription.
     */
    public function unassignAccount($subscriptionId)
    {
        $subscription = \App\Models\Subscription::findOrFail($subscriptionId);

        if ($subscription->account_id) {
            $account = \App\Models\Account::find($subscription->account_id);
            if ($account) {
                $account->decrement('current_users');
            }

            $subscription->update(['account_id' => null]);

            return redirect()->back()
                ->with('success', 'Đã hủy gán tài khoản thành công.');
        }

        return redirect()->back()
            ->with('info', 'Subscription này chưa được gán tài khoản.');
    }
}
