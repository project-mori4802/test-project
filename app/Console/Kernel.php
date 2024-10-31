<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends ConsoleKernel
{
    /**
     * タスクスケジュールを定義
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:senduser')->dailyAt('13:00');

        // タスクリマインダーを3時間ごとに実行
        $schedule->command('reminder:tasks')->everyMinute();
    }


    /**
     * コマンドの登録を行います。
     *
     * @return void
     */
    protected function commands()
    {
        // アプリケーションの全てのコマンドを自動登録
        $this->load(__DIR__.'/Commands');

        // カスタムコマンドの定義
        require base_path('routes/console.php');
    }
}
