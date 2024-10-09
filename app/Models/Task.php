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
        'created_at',
        'updated_at',
        'deleted_at', // ソフトデリートを使用する場合
        'user_id', // 作成者のIDを保存するカラム
    ];

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
