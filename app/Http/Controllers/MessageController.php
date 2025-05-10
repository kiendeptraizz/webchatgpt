<?php

namespace App\Http\Controllers;

use App\Models\AutoReply;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Hiển thị trang chat cho người dùng.
     */
    public function index(): View
    {
        $user = Auth::user();
        $messages = Message::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Nếu không có tin nhắn nào, tạo tin nhắn chào hỏi tự động
        if ($messages->count() === 0) {
            // Tạo tin nhắn chào hỏi từ admin
            $welcomeMessage = Message::create([
                'user_id' => $user->id,
                'content' => 'Xin chào ' . $user->name . '! Cảm ơn bạn đã liên hệ với Trung Kiên Unlock. Tôi là tư vấn viên, tôi có thể giúp gì cho bạn? Nếu cần tư vấn gấp, bạn có thể liên hệ Zalo 0378059206.',
                'is_from_admin' => true,
                'is_auto_reply' => true,
                'is_read' => true,
            ]);

            // Thêm tin nhắn chào hỏi vào danh sách tin nhắn
            $messages = Message::where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // Đánh dấu tất cả tin nhắn từ admin là đã đọc
        Message::where('user_id', $user->id)
            ->where('is_from_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Lấy subscription đang hoạt động của người dùng (nếu có)
        $activeSubscription = $user->subscriptions()
            ->where('active', true)
            ->where('end_date', '>', now())
            ->with('package')
            ->first();

        return view('dashboard.chat', compact('messages', 'activeSubscription'));
    }

    /**
     * Gửi tin nhắn mới từ người dùng.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Lưu tin nhắn của người dùng
        $message = Message::create([
            'user_id' => $user->id,
            'content' => $request->content,
            'is_from_admin' => false,
            'is_auto_reply' => false,
            'is_read' => false,
        ]);

        // Kiểm tra và tạo phản hồi tự động
        $autoReply = $this->getAutoReply($request->content);
        $replyMessage = null;

        if ($autoReply) {
            $replyMessage = Message::create([
                'user_id' => $user->id,
                'content' => $autoReply->response,
                'is_from_admin' => true,
                'is_auto_reply' => true,
                'is_read' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'auto_reply' => $replyMessage,
        ]);
    }

    /**
     * Lấy tin nhắn mới cho người dùng.
     */
    public function getMessages(): JsonResponse
    {
        $user = Auth::user();
        $messages = Message::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    /**
     * Đánh dấu tin nhắn đã đọc.
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $request->validate([
            'message_id' => 'required|exists:messages,id',
        ]);

        $message = Message::findOrFail($request->message_id);

        // Chỉ người dùng có thể đánh dấu tin nhắn từ admin là đã đọc
        if (Auth::id() === $message->user_id && $message->is_from_admin) {
            $message->update(['is_read' => true]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Tìm câu trả lời tự động phù hợp với nội dung tin nhắn.
     */
    private function getAutoReply(string $content): ?AutoReply
    {
        // Lấy tất cả các câu trả lời tự động đang hoạt động, sắp xếp theo độ ưu tiên
        $autoReplies = AutoReply::where('is_active', true)
            ->orderBy('priority', 'desc')
            ->get();

        foreach ($autoReplies as $reply) {
            // Kiểm tra xem từ khóa có trong nội dung tin nhắn không
            if (stripos($content, $reply->keyword) !== false) {
                return $reply;
            }
        }

        return null;
    }
}
