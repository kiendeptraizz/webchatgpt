<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy user đầu tiên (Test User)
        $user = User::first();

        // Lấy gói 69K
        $package = Package::where('price', 69000)->first();

        if ($user && $package) {
            // Tạo subscription mới
            Subscription::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'active' => true,
                'payment_proof' => null, // Không có ảnh thanh toán
            ]);
        }
    }
}
