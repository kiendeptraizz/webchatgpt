<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Không xóa dữ liệu cũ vì có ràng buộc khóa ngoại
        // Thay vào đó, chúng ta sẽ thêm mới các gói dịch vụ

        // AI & CÔNG CỤ SÁNG TẠO - TÀI KHOẢN CHÍNH CHỦ
        // ChatGPT Plus
        Package::create([
            'name' => 'ChatGPT Plus',
            'description' => 'Tài khoản ChatGPT Plus chính chủ',
            'price' => 380000,
            'max_users' => 1,
            'features' => json_encode([
                '✅ Truy cập đầy đủ tính năng GPT-4.5',
                '✅ Không giới hạn tin nhắn và tải tệp',
                '✅ Ưu tiên khi máy chủ bận',
                '✅ Truy cập sớm tính năng mới',
                '✅ Sử dụng trên mọi thiết bị',
                '✅ Tài khoản chính chủ, an toàn tuyệt đối'
            ]),
            'category' => 'personal',
            'category_group' => 'ai_creative',
            'is_shared' => false,
            'is_combo' => false
        ]);

        // Canva Pro
        Package::create([
            'name' => 'Canva Pro',
            'description' => 'Tài khoản Canva Pro chính chủ',
            'price' => 150000,
            'max_users' => 1,
            'features' => json_encode([
                '✅ Thêm thành viên gia đình',
                '✅ Hơn 100 triệu hình ảnh, video premium',
                '✅ 610.000+ mẫu thiết kế chuyên nghiệp',
                '✅ Công cụ xóa nền, Magic Edit',
                '✅ Tạo nội dung AI với Text to Image',
                '✅ Xuất file chất lượng cao không watermark'
            ]),
            'category' => 'personal',
            'category_group' => 'ai_creative',
            'is_shared' => false,
            'is_combo' => false
        ]);

        // AI & CÔNG CỤ SÁNG TẠO - GÓI DÙNG CHUNG
        // Grok AI
        Package::create([
            'name' => 'Grok AI',
            'description' => 'Gói dịch vụ Grok AI dùng chung',
            'price' => 69000,
            'max_users' => 3,
            'features' => json_encode([
                '✅ Truy cập chatbot của Elon Musk',
                '✅ Dùng trên nền tảng X',
                '✅ Cập nhật thông tin thời gian thực',
                '✅ Phong cách hài hước, sáng tạo',
                '✅ Trả lời không bị kiểm duyệt như ChatGPT',
                '✅ Dùng chung - tiết kiệm chi phí'
            ]),
            'category' => 'shared',
            'category_group' => 'ai_creative',
            'is_shared' => true,
            'is_combo' => false
        ]);

        // ChatGPT Cơ bản
        Package::create([
            'name' => 'ChatGPT Cơ bản',
            'description' => 'Gói dịch vụ ChatGPT dùng chung cơ bản',
            'price' => 69000,
            'max_users' => 6,
            'features' => json_encode([
                '✅ 👥 6 người | 1 thiết bị',
                '✅ Không giới hạn câu hỏi',
                '✅ Không giới hạn tải tệp',
                '✅ Giới hạn AI nâng cao',
                '✅ Phù hợp nhóm đông, nhu cầu cơ bản',
                '✅ Hỗ trợ 24/7 khi gặp vấn đề'
            ]),
            'category' => 'shared',
            'category_group' => 'ai_creative',
            'is_shared' => true,
            'is_combo' => false
        ]);

        // ChatGPT Nâng cao
        Package::create([
            'name' => 'ChatGPT Nâng cao',
            'description' => 'Gói dịch vụ ChatGPT dùng chung nâng cao',
            'price' => 139000,
            'max_users' => 3,
            'features' => json_encode([
                '✅ 👥 3 người | 2 thiết bị',
                '✅ Truy cập GPT-4.5 mới nhất',
                '✅ Không giới hạn tải tệp và câu hỏi',
                '✅ Tối ưu cho công việc nâng cao',
                '✅ Phù hợp cho sáng tạo, lập trình, phân tích',
                '✅ Hỗ trợ 24/7 khi gặp vấn đề'
            ]),
            'category' => 'shared',
            'category_group' => 'ai_creative',
            'is_shared' => true,
            'is_combo' => false
        ]);

        // GIẢI TRÍ & ĐA PHƯƠNG TIỆN
        // YouTube Premium
        Package::create([
            'name' => 'YouTube Premium',
            'description' => 'Tài khoản YouTube Premium chính chủ',
            'price' => 430000,
            'max_users' => 1,
            'features' => json_encode([
                '✅ Xem video không quảng cáo',
                '✅ Tải video xem offline',
                '✅ Phát nhạc nền khi tắt màn hình',
                '✅ YouTube Music Premium',
                '✅ Tài khoản chính chủ, an toàn tuyệt đối',
                '✅ Sử dụng trên mọi thiết bị'
            ]),
            'category' => 'personal',
            'category_group' => 'entertainment',
            'is_shared' => false,
            'is_combo' => false
        ]);

        // Spotify Premium
        Package::create([
            'name' => 'Spotify Premium',
            'description' => 'Tài khoản Spotify Premium chính chủ',
            'price' => 300000,
            'max_users' => 1,
            'features' => json_encode([
                '✅ Nghe nhạc không quảng cáo',
                '✅ Tải nhạc nghe offline',
                '✅ Chất lượng âm thanh cao cấp',
                '✅ Phát bất kỳ bài hát nào',
                '✅ Tài khoản chính chủ, an toàn tuyệt đối',
                '✅ Sử dụng trên mọi thiết bị'
            ]),
            'category' => 'personal',
            'category_group' => 'entertainment',
            'is_shared' => false,
            'is_combo' => false
        ]);

        // CapCut Pro
        Package::create([
            'name' => 'CapCut Pro',
            'description' => 'Tài khoản CapCut Pro chính chủ',
            'price' => 600000,
            'max_users' => 1,
            'features' => json_encode([
                '✅ Công cụ chỉnh sửa video chuyên nghiệp',
                '✅ Thư viện hiệu ứng, nhạc nền premium',
                '✅ Xuất video chất lượng cao không watermark',
                '✅ Công cụ AI tiên tiến',
                '✅ Tài khoản chính chủ, an toàn tuyệt đối',
                '✅ Sử dụng trên mọi thiết bị'
            ]),
            'category' => 'personal',
            'category_group' => 'entertainment',
            'is_shared' => false,
            'is_combo' => false
        ]);

        // COMBO TIẾT KIỆM
        // Combo Sáng tạo
        Package::create([
            'name' => 'Combo Sáng tạo',
            'description' => 'ChatGPT Plus + Canva Pro - Hoàn hảo cho người làm sáng tạo nội dung',
            'price' => 500000,
            'max_users' => 1,
            'features' => json_encode([
                'ChatGPT Plus + Canva Pro',
                'Giá: 500K/tháng (Tiết kiệm 30K)',
                'Hoàn hảo cho người làm sáng tạo nội dung',
                'Truy cập đầy đủ tính năng của cả hai dịch vụ',
                'Tài khoản chính chủ, an toàn tuyệt đối',
                'Hỗ trợ kỹ thuật 24/7'
            ]),
            'category' => 'combo',
            'category_group' => 'combo',
            'is_shared' => false,
            'is_combo' => true
        ]);

        // Combo Giải trí
        Package::create([
            'name' => 'Combo Giải trí',
            'description' => 'YouTube Premium + Spotify - Trải nghiệm giải trí đỉnh cao không quảng cáo',
            'price' => 650000,
            'max_users' => 1,
            'features' => json_encode([
                'YouTube Premium + Spotify',
                'Giá: 650K/năm (Tiết kiệm 80K)',
                'Trải nghiệm giải trí đỉnh cao không quảng cáo',
                'Truy cập đầy đủ tính năng của cả hai dịch vụ',
                'Tài khoản chính chủ, an toàn tuyệt đối',
                'Hỗ trợ kỹ thuật 24/7'
            ]),
            'category' => 'combo',
            'category_group' => 'combo',
            'is_shared' => false,
            'is_combo' => true
        ]);

        // Combo All-in-one
        Package::create([
            'name' => 'Combo All-in-one',
            'description' => 'ChatGPT Nâng cao + Canva Pro + YouTube Premium - Giải pháp toàn diện cho công việc và giải trí',
            'price' => 1200000,
            'max_users' => 3,
            'features' => json_encode([
                'ChatGPT Nâng cao + Canva Pro + YouTube Premium',
                'Giá: 1.2 triệu/năm (Tiết kiệm 150K)',
                'Giải pháp toàn diện cho công việc và giải trí',
                'Truy cập đầy đủ tính năng của cả ba dịch vụ',
                'Tài khoản chính chủ, an toàn tuyệt đối',
                'Hỗ trợ kỹ thuật 24/7'
            ]),
            'category' => 'combo',
            'category_group' => 'combo',
            'is_shared' => false,
            'is_combo' => true
        ]);
    }
}
