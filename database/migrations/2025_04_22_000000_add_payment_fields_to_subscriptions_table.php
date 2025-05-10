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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('payment_proof');
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending')->after('payment_method');
            $table->text('payment_notes')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'payment_notes']);
        });
    }
};
