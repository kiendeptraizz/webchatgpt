<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AutoReply;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminMessageController extends Controller
{
    /**
     * Hiển thị trang quản lý tin nhắn cho admin.
     */
    public function index(): View
    {
        // Lấy danh sách người dùng có tin nhắn, sắp xếp theo tin nhắn mới nhất
        $users = User::whereHas('messages')
            ->where('role', 'user')
            ->withCount(['messages as unread_count' => function ($query) {
                $query->where('is_from_admin', false)
                    ->where('is_read', false);
            }])
            ->orderBy('unread_count', 'desc')
            ->get();

        // Lấy danh sách câu trả lời tự động
        $autoReplies = AutoReply::orderBy('priority', 'desc')->get();

        return view('admin.messages', compact('users', 'autoReplies'));
    }

    /**
     * Hiển thị cuộc trò chuyện với một người dùng cụ thể.
     */
    public function show($userId): View
    {
        $user = User::findOrFail($userId);
        
        // Lấy tất cả tin nhắn giữa admin và người dùng
        $messages = Message::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Đánh dấu tất cả tin nhắn từ người dùng là đã đọc
        Message::where('user_id', $userId)
            ->where('is_from_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('admin.chat', compact('user', 'messages'));
    }

    /**
     * Gửi tin nhắn từ admin đến người dùng.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $admin = Auth::user();
        
        // Lưu tin nhắn từ admin
        $message = Message::create([
            'user_id' => $request->user_id,
            'admin_id' => $admin->id,
            'content' => $request->content,
            'is_from_admin' => true,
            'is_auto_reply' => false,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Lấy tin nhắn mới cho admin.
     */
    public function getMessages($userId): JsonResponse
    {
        $messages = Message::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Đánh dấu tất cả tin nhắn từ người dùng là đã đọc
        Message::where('user_id', $userId)
            ->where('is_from_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    /**
     * Hiển thị trang quản lý câu trả lời tự động.
     */
    public function autoReplies(): View
    {
        $autoReplies = AutoReply::orderBy('priority', 'desc')->get();
        return view('admin.auto_replies', compact('autoReplies'));
    }

    /**
     * Lưu câu trả lời tự động mới.
     */
    public function storeAutoReply(Request $request): RedirectResponse
    {
        $request->validate([
            'keyword' => 'required|string|max:100',
            'response' => 'required|string|max:1000',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        AutoReply::create([
            'keyword' => $request->keyword,
            'response' => $request->response,
            'priority' => $request->priority,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.auto-replies')
            ->with('success', 'Câu trả lời tự động đã được tạo thành công.');
    }

    /**
     * Cập nhật câu trả lời tự động.
     */
    public function updateAutoReply(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'keyword' => 'required|string|max:100',
            'response' => 'required|string|max:1000',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $autoReply = AutoReply::findOrFail($id);
        $autoReply->update([
            'keyword' => $request->keyword,
            'response' => $request->response,
            'priority' => $request->priority,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.auto-replies')
            ->with('success', 'Câu trả lời tự động đã được cập nhật thành công.');
    }

    /**
     * Xóa câu trả lời tự động.
     */
    public function destroyAutoReply($id): RedirectResponse
    {
        $autoReply = AutoReply::findOrFail($id);
        $autoReply->delete();

        return redirect()->route('admin.auto-replies')
            ->with('success', 'Câu trả lời tự động đã được xóa thành công.');
    }
}
