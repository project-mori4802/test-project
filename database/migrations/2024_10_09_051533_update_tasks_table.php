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
        Schema::table('tasks', function (Blueprint $table) {
            $table->tinyInteger('priority_id')->after('priority'); // 優先度の追加
            $table->tinyInteger('category_id'); // カテゴリーIDの追加
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['priority_id', 'category_id']); // 追加したカラムを削除
        });
    }
};
