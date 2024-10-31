<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;
use App\Mail\SendMail;

class SendUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:senduser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'タスクの締切日が近い場合、ユーザーにメールを送信する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // // 現在の日付から3日後の日付を取得
        // $now = Carbon::now();
        // $deadlineThreshold = $now->copy()->addDays(3);

        // // 締切日が近いタスクを取得
        // $tasks = Task::where('due_date', '<=', $deadlineThreshold)
        //     ->where('status_id', '!=', '3') // 完了していないタスクのみ
        //     ->get();

        // // ユーザーにメールを送信
        // foreach ($tasks as $task) {
        //     if ($task->user) { // タスクに関連付けられたユーザーがいるか確認
        //         Mail::to($task->user->email)->send(new SendMail($task));
        //         $this->info("メールが送信されました: " . $task->user->email);
        //     } else {
        //         $this->warn("タスク ID {$task->id} に関連付けられたユーザーが見つかりませんでした。");
        //     }
        // }

        // // タスクが見つからなかった場合のメッセージ
        // if ($tasks->isEmpty()) {
        //     $this->info("締切日が近いタスクはありませんでした。");
        // }
    }
}
