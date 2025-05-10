<?php

namespace App\Http\Controllers;

use App\Models\AutoReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AutoReplyController extends Controller
{
    /**
     * Thêm hoặc cập nhật các câu trả lời tự động
     */
    public function updateAutoReplies()
    {
        // Cập nhật câu trả lời tự động về thanh toán
        $this->updateOrCreateAutoReply(
            'thanh toán',
            'Chúng tôi hỗ trợ thanh toán qua chuyển khoản ngân hàng và ví điện tử MoMo. Vui lòng liên hệ với chúng tôi qua Zalo 0378059206 để được hướng dẫn chi tiết về cách thanh toán.',
            2
        );

        // Cập nhật câu trả lời tự động về MoMo
        $this->updateOrCreateAutoReply(
            'momo',
            'Bạn có thể thanh toán qua MoMo bằng cách quét mã QR hoặc chuyển khoản đến số điện thoại 0378059206 (TRUNG KIÊN).',
            3
        );

        // Cập nhật câu trả lời tự động về Zalo
        $this->updateOrCreateAutoReply(
            'zalo',
            'Bạn có thể liên hệ với chúng tôi qua Zalo theo số 0378059206 để được tư vấn và hỗ trợ nhanh nhất.',
            3
        );

        // Cập nhật câu trả lời tự động về liên hệ
        $this->updateOrCreateAutoReply(
            'liên hệ',
            'Bạn có thể liên hệ với chúng tôi qua Zalo 0378059206. Hoặc bạn có thể để lại tin nhắn tại đây và chúng tôi sẽ phản hồi sớm nhất có thể.',
            2
        );

        // Cập nhật câu trả lời tự động về tư vấn
        $this->updateOrCreateAutoReply(
            'tư vấn',
            'Để được tư vấn chi tiết, vui lòng liên hệ với chúng tôi qua Zalo 0378059206. Chúng tôi sẽ hỗ trợ bạn nhanh nhất có thể.',
            2
        );

        // Cập nhật câu trả lời tự động về chào hỏi
        $this->updateOrCreateAutoReply(
            'xin chào',
            'Xin chào! Cảm ơn bạn đã liên hệ với Trung Kiên Unlock. Tôi là tư vấn viên, tôi có thể giúp gì cho bạn? Nếu cần tư vấn gấp, bạn có thể liên hệ Zalo 0378059206.',
            1
        );

        // Cập nhật câu trả lời tự động về hello
        $this->updateOrCreateAutoReply(
            'hello',
            'Xin chào! Cảm ơn bạn đã liên hệ với Trung Kiên Unlock. Tôi là tư vấn viên, tôi có thể giúp gì cho bạn? Nếu cần tư vấn gấp, bạn có thể liên hệ Zalo 0378059206.',
            1
        );

        // Cập nhật câu trả lời tự động về hi
        $this->updateOrCreateAutoReply(
            'hi',
            'Xin chào! Cảm ơn bạn đã liên hệ với Trung Kiên Unlock. Tôi là tư vấn viên, tôi có thể giúp gì cho bạn? Nếu cần tư vấn gấp, bạn có thể liên hệ Zalo 0378059206.',
            1
        );

        return redirect()->back()->with('success', 'Đã cập nhật các câu trả lời tự động thành công!');
    }

    /**
     * Cập nhật hoặc tạo mới câu trả lời tự động
     */
    private function updateOrCreateAutoReply($keyword, $response, $priority)
    {
        AutoReply::updateOrCreate(
            ['keyword' => $keyword],
            [
                'response' => $response,
                'is_active' => true,
                'priority' => $priority,
            ]
        );
    }
}
