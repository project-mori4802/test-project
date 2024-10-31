<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Notification;
use App\Models\Task;
use App\Models\User; // Userモデルをインポート
use App\Models\Notification;
use Carbon\Carbon;

class ReminderTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '期限が近いタスクをリマインドします';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 現在日付のタスクを取得
        $today = Carbon::today(); // 現在の日付を取得

        // 本日が期限のタスクを取得
        $reminderTasks = Task::whereDate('due_date', $today) // 期限日が今日のタスクを取得
            ->get();

        // $this->info('本日が期限のタスクを取得: ' . $reminderTasks);

        if ($reminderTasks->isNotEmpty()) {
            foreach ($reminderTasks as $task) {
                $user = User::find($task->user_id);
                $this->info('該当タスクのユーザーを取得: ' . $user);
                

                if ($user) {
                    // 通知データをテーブルに保存
                    Notification::create([
                        'user_id' => $user->id,
                        'message' => $task->title,
                    ]);
                }
            }
            $this->info('期限が近いタスク情報をnotificationテーブルに登録しました。');
        } else {
            $this->info('期限が近いタスクはありません。');
        }
    }
}
