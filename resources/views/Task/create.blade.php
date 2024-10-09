<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('タスク新規登録画面') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- タスクエリア -->
                    <div class="task-container">
                        <div class="create-box">
                            <div class="create-header">
                                <h2>タスク　新規作成</h2>
                            </div>

                            <!-- 新規登録フォーム -->
                            <form method="POST" action="{{ route('Task.store') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userId }}">

                                <div class="create-detail">
                                    <!-- 作成者 -->
                                    <div>
                                        <label for="">作成者</label>
                                        <p>{{ $userName }}</p>
                                    </div>
    
                                    <!-- タスク名 -->
                                    <div>
                                        <label for="">タスク名</label>
                                        <input type="text" name="title" id="title" placeholder="入力してください" value="">
                                    </div>
    
                                    <!-- カテゴリー -->
                                    <div>
                                        <label for="">カテゴリー</label>
                                        <select name="category_id" id="category_id" required>
                                            <option value="" disabled selected class="opacity-option">選択してください</option> <!-- デフォルトの選択肢 -->
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <!-- 優先度 -->
                                    <div>
                                        <label for="">優先度</label>
                                        <select name="priority_id" id="priority_id" required>
                                            <option value="" disabled selected class="opacity-option">選択してください</option> <!-- デフォルトの選択肢 -->
                                            @foreach ($priorities as $priority)
                                                <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <!-- 期限 -->
                                    <div>
                                        <label for="">期限</label>
                                        <input type="text" name="due_date" class="form-control" id="deadline" placeholder="日付を選択">
                                    </div>
    
                                    <!-- タスク詳細 -->
                                    <div>
                                        <label for="">詳細説明</label>
                                        <textarea name="description" id="description" value=""></textarea>
                                    </div>
    
                                </div>
    
                                <div class="create-bottom">
                                    <button>新規 タスク作成</button>
                                    <a href="{{ route('Task.index') }}">戻る</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#deadline').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                language: 'ja' // 日本語ローカライズ
            });
        });
    </script>
</x-app-layout>
