<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard Statistics
    |--------------------------------------------------------------------------
    |
    | Các thông số thống kê hiển thị trên dashboard của admin
    | Có thể chỉnh sửa các giá trị này để thay đổi thông tin hiển thị
    |
    */

    // Các giá trị này sẽ được tính toán động từ dữ liệu thực tế trong AdminController
    'weekly_revenue' => 692000, // Doanh thu tuần: 692.000 đồng
    'total_revenue' => 1037000, // Tổng doanh thu: 1.037.000 đồng
    'accounts_sold' => 1, // Số tài khoản đã bán
    'total_buyers' => 13, // Số người mua (số subscription đã kích hoạt)
    'basic_package_percent' => 65, // Phần trăm gói cơ bản
    'advanced_package_percent' => 35, // Phần trăm gói nâng cao
    'revenue_data' => [650000, 590000, 800000, 810000, 960000, 1050000, 840000], // Dữ liệu doanh thu theo ngày
];
