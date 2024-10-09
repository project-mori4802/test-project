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
            $table->tinyInteger('priority_id')->unsigned()->default(0)->change();  // 優先度の追加（デフォルト値を設定）
            $table->tinyInteger('category_id')->unsigned()->default(0)->change(); // カテゴリーの追加（デフォルト値を設定）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->tinyInteger('priority_id')->unsigned()->default(null)->change();
            $table->tinyInteger('category_id')->unsigned()->default(null)->change();
        });
    }
};
