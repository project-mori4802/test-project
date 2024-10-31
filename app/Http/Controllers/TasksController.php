<?php

namespace App\Http\Controllers\Tasks;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    // タスク一覧画面
    public function index()
    {
            // セッションの内容を確認
            // dd(session('task_reminders'));

        // tasksテーブルにcategoryとpriorityをJOINさせてデータ取得
        $tasks = Task::with(['category', 'priority', 'status'])->get();
        // $tasks = Task::with(['category', 'priority', 'status'])->take(5)->get();
        // 全タスク数を取得
        $totalTasks = Task::count();
        // カテゴリー情報取得
        $categories = Category::all();
        // 優先度の情報取得
        $priorities = Priority::all();
        // ステータスの情報取得
        $statuses = Status::all();
        return view('Task.index', compact('tasks', 'totalTasks', 'categories', 'priorities', 'statuses'));
    }

    // タスク：カレンダー用データ取得(ajax：データが存在する日付)
    public function date()
    {
        // $query = Task::all();
        // $query->where('due_date');
        $query = Task::pluck('due_date');

        return response()->json($query); // JSON形式で返す
    }

    // タスク：検索機能
    public function search(Request $request)
    {
        try {
            // dd($request->all());
            $query = Task::with(['category', 'priority']); // リレーションも含めてタスクを取得

            // 締切日のフィルタリング
            if ($request->has('due_date') && $request->due_date) {
                $query->where('due_date', $request->due_date);
            }
            
            // 優先度のフィルタリング
            if ($request->has('priority_id') && $request->priority_id) {
                $query->where('priority_id', $request->priority_id);
            }
    
            // カテゴリーのフィルタリング
            if ($request->has('category_id') && $request->category_id) {
                $query->where('category_id', $request->category_id);
            }
    
            // テキスト検索
            if ($request->has('text_search') && $request->text_search) {
                $query->where('title', 'like', '%' . $request->text_search . '%')
                    ->orWhere('description', 'like', '%' . $request->text_search . '%');
            }
    
            // 検索結果を取得
            $tasks = $query->get();
            // dd($tasks);
    
            // カテゴリーと優先度の情報も取得
            $categories = Category::all();
            $priorities = Priority::all();
    
            return view('Task.index', compact('tasks', 'categories', 'priorities'))
                    ->with('request', $request);
        } catch (\Exception $e) {
            // カテゴリーと優先度の情報も取得
            $categories = Category::all();
            $priorities = Priority::all();
    
            return view('Task.index', compact('tasks', 'categories', 'priorities'));
            return redirect()->route('Task.index', compact('tasks', 'categories', 'priorities'))->with('error', '該当するデータが見つかりませんでした。');
        }
        
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
        // ステータスの情報取得
        $statuses = Status::all();
        return view('Task.create', compact('userName', 'userId', 'categories', 'priorities', 'statuses'));
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
            'status_id'   => $request->status_id,
            'due_date'    => $request->due_date,
            'description' => $request->description,
        ]);
        
        // タスク一覧ページにリダイレクト
        return redirect()->route('Task.index')->with('success', 'タスクが正常に登録されました');
    }

    // タスク：編集画面表示
    public function edit(Request $request, $id)
    {
        // タスクをIDで取得。見つからない場合は404エラーを発生させる
        $task = Task::with(['user', 'category', 'priority'])->findOrFail($id);
        // dd($task);
        // カテゴリー情報取得
        $categories = Category::all();
        // 優先度の情報取得
        $priorities = Priority::all();
        // ステータスの情報取得
        $statuses = Status::all();
        return view('Task.edit', compact('task', 'categories', 'priorities', 'statuses'));        
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // タスクを取得（存在しない場合は404エラー）
        $task = Task::findOrFail($id);
        // dd($task);
        // バリデーション実行
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|integer',
            'priority_id' => 'required|integer',
            'due_date'    => 'required|date',
            'description' => 'nullable|string',
        ]);

        // 更新実行
        $task->update([
            'title'       => $request->title,
            'category_id' => $request->category_id, // カテゴリーは整数として扱う
            'priority_id' => $request->priority_id,
            'status_id'   => $request->status_id,
            'due_date'    => $request->due_date,
            'description' => $request->description,
        ]);

        // タスク一覧ページにリダイレクト
        return redirect()->route('Task.index')->with('success', 'タスクが正常に更新されました');
    }

    public function delete($id)
    {
        // タスクを取得（存在しない場合は404エラー）
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('Task.index')->with('success', 'タスクが削除されました。');
    }

    // タスク：期限が近いデータを取得
    public function notification()
    {
        // notificationテーブルから「message」カラムのデータ取得
        $query = Notification::pluck('id', 'message');
        
        // JSON形式で返す
        return response()->json($query);
    }

    public function notificationDel($id)
    {
        try {
            $notification = Notification::find($id);

            if (!$notification) {
                return response()->json(['error' => 'タスクが見つかりません。'], 404);
            }
        
            $notification->delete();
        
            return response()->json(['message' => 'タスクが正常に削除されました。'], 200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'エラーが発生しました。');
        }
        
    }



}
