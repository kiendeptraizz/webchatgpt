<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoReplyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
// Trang chủ - hiển thị danh sách gói dịch vụ
Route::get('/', [PackageController::class, 'index'])->name('home');

// Trang chi tiết gói dịch vụ
Route::get('/packages/{id}', [PackageController::class, 'show'])->name('packages.show');

// Xử lý đăng ký gói dịch vụ (yêu cầu đăng nhập)
Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe');

// Thanh toán
Route::get('/payment/{id}', [SubscriptionController::class, 'showPayment'])->name('payment.show');
Route::post('/payment/{id}/process', [SubscriptionController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/{id}/confirmation', [SubscriptionController::class, 'showConfirmation'])->name('payment.confirmation');

// Features page
Route::get('/features', function () {
    return view('features');
})->name('features');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    // Xử lý form liên hệ
    return redirect()->route('contact')
        ->with('success', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất có thể.');
})->name('contact.submit');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Social login routes
Route::get('/auth/{provider}', [AuthController::class, 'redirectToProvider'])->name('auth.social');
Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Chat routes
    Route::get('/chat', [MessageController::class, 'index'])->name('chat');
    Route::post('/chat/send', [MessageController::class, 'store'])->name('chat.store');

    // Referral routes
    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals');
    Route::post('/referrals/generate-link', [ReferralController::class, 'generateLink'])->name('referrals.generate-link');
    Route::get('/chat/messages', [MessageController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/read', [MessageController::class, 'markAsRead'])->name('chat.read');
});

// Admin routes (protected by admin middleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Packages management
    Route::get('/packages', [AdminController::class, 'packages'])->name('packages');
    Route::post('/packages', [AdminController::class, 'storePackage'])->name('packages.store');
    Route::put('/packages/{id}', [AdminController::class, 'updatePackage'])->name('packages.update');
    Route::delete('/packages/{id}', [AdminController::class, 'destroyPackage'])->name('packages.destroy');

    // Subscriptions management
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions');
    Route::put('/subscriptions/{id}/activate', [AdminController::class, 'activateSubscription'])->name('subscriptions.activate');
    Route::delete('/subscriptions/{id}', [AdminController::class, 'destroySubscription'])->name('subscriptions.destroy');

    // Messages management
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages');
    Route::get('/messages/{userId}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [AdminMessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{userId}/get', [AdminMessageController::class, 'getMessages'])->name('messages.get');

    // Auto replies management
    Route::get('/auto-replies', [AdminMessageController::class, 'autoReplies'])->name('auto-replies');
    Route::post('/auto-replies', [AdminMessageController::class, 'storeAutoReply'])->name('auto-replies.store');
    Route::put('/auto-replies/{id}', [AdminMessageController::class, 'updateAutoReply'])->name('auto-replies.update');
    Route::delete('/auto-replies/{id}', [AdminMessageController::class, 'destroyAutoReply'])->name('auto-replies.destroy');
    Route::get('/auto-replies/update-defaults', [AutoReplyController::class, 'updateAutoReplies'])->name('auto-replies.update-defaults');

    // Accounts management
    Route::resource('accounts', \App\Http\Controllers\Admin\AccountController::class);
    Route::post('/accounts/assign', [\App\Http\Controllers\Admin\AccountController::class, 'assignAccount'])->name('accounts.assign');
    Route::post('/accounts/unassign/{subscription}', [\App\Http\Controllers\Admin\AccountController::class, 'unassignAccount'])->name('accounts.unassign');
    Route::post('/accounts/assign-user', [\App\Http\Controllers\Admin\AccountController::class, 'assignUser'])->name('accounts.assign-user');

    // Reports
    Route::get('/reports/subscriptions', [\App\Http\Controllers\Admin\ReportController::class, 'exportSubscriptions'])->name('reports.subscriptions');
    Route::get('/reports/subscriptions/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'exportSubscriptionDetail'])->name('reports.subscription.detail');

    // Referrals
    Route::get('/referrals', [\App\Http\Controllers\Admin\ReferralController::class, 'index'])->name('referrals');
    Route::post('/referrals/{id}/approve', [\App\Http\Controllers\Admin\ReferralController::class, 'approve'])->name('referrals.approve');

    // Categories management
    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    // Promotions management
    Route::get('/promotions', [\App\Http\Controllers\Admin\PromotionController::class, 'index'])->name('promotions.index');
    Route::get('/promotions/create', [\App\Http\Controllers\Admin\PromotionController::class, 'create'])->name('promotions.create');
    Route::post('/promotions', [\App\Http\Controllers\Admin\PromotionController::class, 'store'])->name('promotions.store');
    Route::get('/promotions/{id}/edit', [\App\Http\Controllers\Admin\PromotionController::class, 'edit'])->name('promotions.edit');
    Route::put('/promotions/{id}', [\App\Http\Controllers\Admin\PromotionController::class, 'update'])->name('promotions.update');
    Route::delete('/promotions/{id}', [\App\Http\Controllers\Admin\PromotionController::class, 'destroy'])->name('promotions.destroy');
});
