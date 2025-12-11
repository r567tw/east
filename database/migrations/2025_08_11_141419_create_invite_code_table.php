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
        Schema::create('invite_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('邀請碼');
            $table->timestamp('expires_at')->nullable()->comment('邀請碼過期時間');
            $table->boolean('is_used')->default(false)->comment('是否已使用');
            $table->timestamp('used_at')->nullable()->comment('使用邀請碼的時間');
            $table->unsignedBigInteger('user_id')->nullable()->comment('使用邀請碼的用戶ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invite_codes');
    }
};
