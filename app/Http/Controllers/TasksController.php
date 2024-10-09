<?php

namespace App\Http\Controllers\Tasks;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use App\Models\Category;
use App\Models\Priority;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    // タスク一覧画面
    public function index()
    {
        // タスクデータを取得し、関連するユーザーも一緒に取得
        $tasks = Task::with('user')->take(5)->get();
        // 全タスク数を取得
        $totalTasks = Task::count();
        return view('Task.index', compact('tasks', 'totalTasks'));
    }

    // タスク：新規登録画面
    public function create()
    {
        // ログインしているユーザーの名前を取得
        $user = Auth::user();
        $userName = $user->name;
        $userId = $user->id;
        // カテゴリー情報取得
        $categories = Category::all();
        // 優先度の情報取得
        $priorities = Priority::all();
        return view('Task.create', compact('userName', 'userId', 'categories', 'priorities'));
    }

    // タスク：新規登録機能
    public function store(Request $request)
    {
        // dd($request->all());
        // バリデーション実行
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|integer',
            'priority_id' => 'required|integer',
            'due_date'    => 'required|date',
            'description' => 'nullable|string',
        ]);

        // 新しいタスクを作成
        Task::create([
            'user_id'     => Auth::id(), // ログインしているユーザーのIDを使用
            'title'       => $request->title,
            'category_id' => $request->category_id, // カテゴリーは整数として扱う
            'priority_id' => $request->priority_id,
            'due_date'    => $request->due_date,
            'description' => $request->description,
        ]);
        
        // タスク一覧ページにリダイレクト
        return redirect()->route('Task.index')->with('success', 'タスクが正常に登録されました');
    }
}
