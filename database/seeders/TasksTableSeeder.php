<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('tasks')->insert([
        //     [
        //         'title' => 'タスク1',
        //         'description' => 'タスク1の説明',
        //         'priority' => 1,
        //         'due_date' => '2024-10-10',
        //         'is_completed' => false,
        //         'created_at' => now(),
        //         'deleted_at' => null,
        //         'user_id' => 1, // 存在するユーザーIDを指定
        //     ],
        //     [
        //         'title' => 'タスク2',
        //         'description' => 'タスク2の説明',
        //         'priority' => 2,
        //         'due_date' => '2024-10-15',
        //         'is_completed' => false,
        //         'created_at' => now(),
        //         'deleted_at' => null,
        //         'user_id' => 1, // 存在するユーザーIDを指定
        //     ],
        //     [
        //         'title' => 'タスク3',
        //         'description' => 'タスク3の説明',
        //         'priority' => 3,
        //         'due_date' => '2024-10-20',
        //         'is_completed' => true,
        //         'created_at' => now(),
        //         'deleted_at' => null,
        //         'user_id' => 1, // 存在するユーザーIDを指定
        //     ],
        //     // 他のタスクを追加する場合は、ここに続けて記述
        // ]);
    }
}
