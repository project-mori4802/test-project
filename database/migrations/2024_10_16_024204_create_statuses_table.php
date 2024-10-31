<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id(); // ステータス ID（自動増分、主キー）
            $table->string('name', 255); // ステータス 名
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP')); // 作成日（TIMESTAMP、NOT NULL、デフォルトでCURRENT_TIMESTAMP）
            $table->timestamp('updated_at')->nullable(); // 更新日（TIMESTAMP、NULL許可）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
