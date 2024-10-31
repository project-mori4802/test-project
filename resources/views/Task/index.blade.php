<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('タスク一覧') }}
        </h2>
    </x-slot>

    <div class="py-12" id="task-list-page">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- 検索エリア -->
                    <div class="container mt-4">
                        <form method="POST" action="{{ route('Task.search') }}" class="form-inline my-2 my-lg-0">
                        @csrf
                            <!-- 締切日 -->
                            <div class="form-group">
                                <label for="">締切日</label>
                                <input type="text" name="due_date" class="form-control" id="deadline" placeholder="日付を選択">
                            </div>

                            <!-- 優先度 -->
                            <div class="form-group">
                                <label for="">優先度</label>
                                <select name="priority_id" class="form-control" id="priority_id">
                                    <option value="" selected>全て</option> <!-- デフォルトの選択肢 -->
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}"
                                            {{ (old('priority_id', $request->priority_id ?? '') == $priority->id) ? 'selected' : '' }}>
                                            {{ $priority->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- ステータス -->
                            <div class="form-group">
                                <label for="exampleSelect">ステータス：</label>
                                <select class="form-control" id="exampleSelect">
                                    <option>全て</option>
                                </select>
                            </div>
                            <!-- カテゴリ -->
                            <div class="form-group">
                                <label for="">カテゴリー</label>
                                <select name="category_id" class="form-control" id="category_id">
                                    <option value="" selected>全て</option> <!-- デフォルトの選択肢 -->
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ (old('category_id', $request->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input name="text_search" class="form-control mr-sm-2" type="search" placeholder="検索" aria-label="検索">
                            </div>
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
                        </form>
                    </div>

                    <!-- タスクエリア -->
                    <div class="task-container">
                        <!-- 全表示 -->
                        <div class="todo-list">
                            <div class="list-header">
                                <h2>ToDoリスト</h2>
                                <a class="dot-menu-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" onclick="textCheck()">
                                    … <!-- 三点リーダー（・・・） -->
                                </a>
                            </div>
                            <a href="{{ route('Task.create') }}" type="button" class="btn btn-outline-primary"><i class="fas fa-plus"></i>タスクを追加</a>

                            @if ($tasks->isEmpty())
                                <div class="item-header text-red-500">
                                    <p class="none-data">データがありません。</p>
                                </div>
                            @else
                                <div class="list-item-box">
                                    @foreach($tasks as $task)
                                        <div class="list-items">
                                            <div class="item-header">
                                                <p>#{{ $task->id }}</p>
                                                <div>
                                                    <p>{{ $task->title }}</p>
                                                    <a class="dot-menu-btn" data-task-id="{{ $task->id }}" type="button">
                                                        … <!-- 三点リーダー（・・・） -->
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- プルダウンメニュー -->
                                            <div class="dropdown-menu" id="dropdown-menu-{{ $task->id }}" style="display: none;">
                                                <ul>
                                                    <li><a href="{{ route('Task.edit', $task->id) }}">編集</a></li>
                                                    <li>
                                                        <form action="{{ route('Task.delete', $task->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">削除</button>
                                                        </form>
                                                    </li>
                                                    <li><a href="">詳細を表示</a></li>
                                                </ul>
                                            </div>

                                            <div class="detail-box">
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
                                                    <div class="">
                                                        <label for="">カテゴリー :</label>
                                                        <p>{{ $task->category->name }}</p>
                                                    </div>
                                                    <div class="">
                                                        <label for="">優先度 :</label>
                                                        <p>{{ $task->priority->name }}</p>
                                                    </div>
                                                    <div class="">
                                                        <label for="">締切日 :</label>
                                                        <p>{{ $task->due_date }}</p>
                                                    </div>
                                                </div>

                                                <div class="detail-down-btn">
                                                    <!-- プラスボタン：表示 -->
                                                    <!-- <button id="plusBtn"><i class="fa-solid fa-plus"></i></button> -->
                                                    <!-- マイナスボタン：非表示 -->
                                                    <!-- <button id="minusBtn" class="hidden"><i class="fa-solid fa-minus"></i></button> -->
                                                    
                                                    @if ($task->status->id == 1)
                                                        <p class="status-1">未実施</p>
                                                    @elseif ($task->status->id == 2)
                                                        <p class="status-2">進行中</p>
                                                    @else
                                                        <p class="status-3">完了</p>
                                                    @endif
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

