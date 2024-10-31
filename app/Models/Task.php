<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // このモデルが操作するテーブル名を指定
    protected $table = 'tasks'; // 必要に応じてテーブル名を指定

    // マスアサインメントのために許可するカラム
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'is_completed',
        'created_at',
        'updated_at',
        'deleted_at', // ソフトデリートを使用する場合
        'user_id', // 作成者のIDを保存するカラム
        'category_id',
        'priority_id',
        'status_id',
    ];

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // カテゴリーとのリレーション定義
    public function category()
    {
        return $this->belongsTo(Category::class); // カテゴリへのリレーション
    }

    // Priorityとのリレーション
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    // Statusとのリレーション
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
