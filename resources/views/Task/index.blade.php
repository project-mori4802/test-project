<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('タスク一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- 検索エリア -->
                    <div class="container mt-4">
                        <form class="form-inline my-2 my-lg-0">
                            <!-- 優先度 -->
                            <div class="form-group">
                                <label for="exampleSelect">優先度</label>
                                <select class="form-control" id="exampleSelect">
                                    <option>オプション 1</option>
                                </select>
                            </div>
                            <!-- ステータス -->
                            <div class="form-group">
                                <label for="exampleSelect">ステータス</label>
                                <select class="form-control" id="exampleSelect">
                                    <option>オプション 1</option>
                                </select>
                            </div>
                            <!-- カテゴリ -->
                            <div class="form-group">
                                <label for="exampleSelect">カテゴリ</label>
                                <select class="form-control" id="exampleSelect">
                                    <option>オプション 1</option>
                                </select>
                            </div>

                            <input class="form-control mr-sm-2" type="search" placeholder="検索" aria-label="検索">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
                        </form>
                    </div>

                    <!-- タスクエリア -->
                    <div class="task-container">
                        <!-- 全表示 -->
                        <div class="todo-list">
                            <div class="list-header">
                                <h2>ToDoリスト</h2>
                                <a class="dot-menu-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    … <!-- 三点リーダー（・・・） -->
                                </a>
                            </div>
                            <a href="{{ route('Task.create') }}" type="button" class="btn btn-outline-primary"><i class="fas fa-plus"></i>タスクを追加</a>

                            @if ($tasks->isEmpty())
                                <div class="item-header text-red-500">
                                    <p>データがありません。</p>
                                </div>
                            @else
                                <div class="list-item-box">
                                    @foreach($tasks as $task)
                                        <div class="list-items">
                                            <div class="item-header">
                                                <p>{{ $task->title }}</p>
                                                <a class="dot-menu-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    … <!-- 三点リーダー（・・・） -->
                                                </a>
                                            </div>
                                            <div class="item-detail">
                                                <div>
                                                    <label for="">内容 :</label>
                                                    <p>{{ $task->description }}</p>
                                                </div>
                                                <div>
                                                    <label for="">作成日 :</label>
                                                    <p>{{ $task->created_at->format('Y-m-d') }}</p>
                                                </div>
                                                <div>
                                                    <label for="">作成者 :</label>
                                                    <p>{{ $task->user->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- フラッシュメッセージを隠れた要素として追加 -->
                    @if (session('success'))
                        <div id="success-message" style="display: none;">{{ session('success') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

