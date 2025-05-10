<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('referral_commissions', function (Blueprint $table) {
            $table->enum('reward_type', ['money', 'extension'])->default('money')->after('status')->comment('Loại phần thưởng: tiền hoặc gia hạn thời gian');
            $table->integer('reward_days')->default(0)->after('reward_type')->comment('Số ngày gia hạn nếu reward_type là extension');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referral_commissions', function (Blueprint $table) {
            $table->dropColumn(['reward_type', 'reward_days']);
        });
    }
};
