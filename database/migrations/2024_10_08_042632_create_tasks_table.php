<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // id（BIGINT、主キー、自動増分）タスクID
            $table->string('title', 255); // title（VARCHAR 255、NOT NULL）タイトル
            $table->text('description')->nullable(); // description（TEXT、NULL許可）詳細説明
            $table->tinyInteger('priority')->default(3); // priority（TINYINT、NOT NULL、デフォルト: 3）タスクの優先度
            $table->date('due_date')->nullable(); // due_date（DATE、NULL許可）タスクの締切日
            $table->boolean('is_completed')->default(0); // is_completed（BOOLEAN、NOT NULL、デフォルト: 0）完了ステータス
            $table->timestamp('created_at')->nullable(); // 作成日（TIMESTAMP、NULL許可）
            $table->timestamp('deleted_at')->nullable(); // 削除日（TIMESTAMP、NULL許可）
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // user_id（BIGINT、外部キー: users.id）タスクの所有者
        });
    }

    /**
     * マイグレーションをもとに戻す
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
