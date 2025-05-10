<?php

namespace Database\Seeders;

use App\Models\AutoReply;
use Illuminate\Database\Seeder;

class AutoReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $autoReplies = [
            [
                'keyword' => 'xin chào',
                'response' => 'Xin chào! Cảm ơn bạn đã liên hệ với WebChatGPT. Chúng tôi có thể giúp gì cho bạn?',
                'is_active' => true,
                'priority' => 1,
            ],
            [
                'keyword' => 'hello',
                'response' => 'Xin chào! Cảm ơn bạn đã liên hệ với WebChatGPT. Chúng tôi có thể giúp gì cho bạn?',
                'is_active' => true,
                'priority' => 1,
            ],
            [
                'keyword' => 'giá',
                'response' => 'Chúng tôi có nhiều gói dịch vụ với mức giá khác nhau. Bạn có thể xem chi tiết tại trang Bảng giá của chúng tôi. Bạn quan tâm đến gói nào?',
                'is_active' => true,
                'priority' => 2,
            ],
            [
                'keyword' => 'thanh toán',
                'response' => 'Chúng tôi hỗ trợ nhiều phương thức thanh toán bao gồm thẻ tín dụng, chuyển khoản ngân hàng, ví điện tử (Momo, ZaloPay, VNPay) và tiền mặt (COD).',
                'is_active' => true,
                'priority' => 2,
            ],
            [
                'keyword' => 'momo',
                'response' => 'Bạn có thể thanh toán qua MoMo bằng cách quét mã QR hoặc chuyển khoản đến số điện thoại 0987654321 (WEBCHATGPT).',
                'is_active' => true,
                'priority' => 3,
            ],
            [
                'keyword' => 'liên hệ',
                'response' => 'Bạn có thể liên hệ với chúng tôi qua email info@webchatgpt.vn hoặc số điện thoại (84) 123 456 789. Hoặc bạn có thể để lại tin nhắn tại đây và chúng tôi sẽ phản hồi sớm nhất có thể.',
                'is_active' => true,
                'priority' => 2,
            ],
            [
                'keyword' => 'cảm ơn',
                'response' => 'Không có gì! Rất vui khi được hỗ trợ bạn. Nếu bạn có bất kỳ câu hỏi nào khác, đừng ngần ngại liên hệ với chúng tôi.',
                'is_active' => true,
                'priority' => 1,
            ],
            [
                'keyword' => 'thank',
                'response' => 'Không có gì! Rất vui khi được hỗ trợ bạn. Nếu bạn có bất kỳ câu hỏi nào khác, đừng ngần ngại liên hệ với chúng tôi.',
                'is_active' => true,
                'priority' => 1,
            ],
            [
                'keyword' => 'đăng ký',
                'response' => 'Để đăng ký sử dụng dịch vụ, bạn có thể truy cập trang web của chúng tôi, chọn gói dịch vụ phù hợp và làm theo hướng dẫn. Nếu bạn cần hỗ trợ, đội ngũ của chúng tôi luôn sẵn sàng giúp đỡ.',
                'is_active' => true,
                'priority' => 2,
            ],
            [
                'keyword' => 'hỗ trợ',
                'response' => 'Đội ngũ hỗ trợ của chúng tôi làm việc từ 8h đến 22h hàng ngày. Bạn có thể để lại tin nhắn và chúng tôi sẽ phản hồi trong thời gian sớm nhất.',
                'is_active' => true,
                'priority' => 2,
            ],
        ];

        foreach ($autoReplies as $reply) {
            AutoReply::create($reply);
        }
    }
}
