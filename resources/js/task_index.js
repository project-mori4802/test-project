// 処理成功時のモーダル表示処理
$(document).ready(function() {
    $(document).ready(function() {
        const successMessage = $('#success-message');
        console.log(successMessage);
        if (successMessage.length) {
            Swal.fire({
                icon: 'success',
                title: '成功',
                text: successMessage.text(),
            });
        }
    });
});

$(document).ready(function() {
    $('.dot-menu-btn').on('click', function(event) {
        event.preventDefault(); // デフォルトの動作を防ぐ
        let taskId = $(this).data('task-id'); // タスクIDを取得
        let dropdownMenu = $('#dropdown-menu-' + taskId); // プルダウンメニューを取得
        let buttonOffset = $(this).offset(); // ボタンの位置を取得
        let menuHeight = dropdownMenu.outerHeight(); // プルダウンメニューの高さを取得
    
        // 他のプルダウンメニューを閉じる
        $('.dropdown-menu').not(dropdownMenu).slideUp(); 
    
        // プルダウンメニューの位置を設定
        dropdownMenu.css({
            top: buttonOffset.top + $(this).outerHeight() + 20, // ボタンの下に表示
            left: buttonOffset.left - 130 // ボタンの横に表示
        });
    
        // プルダウンメニューを表示/非表示
        dropdownMenu.slideToggle();
    });
});

// カレンダー処理
$(document).ready(function() {
    let availableDates = []; // データ格納用の変数

    // サーバからデータを取得
    fetch('/task/date_data')
        .then(response => {
            if (!response.ok) {
                throw new Error('ネットワークの応答が正常ではありませんでした');
            }
            return response.json();
        })
        .then(data => {
            console.log('取得した日付:', data);
            availableDates = data; // 日付を保存
            initializeDatepicker(); // datepickerを初期化
        })
        .catch(error => console.error('Fetch error:', error));

    function initializeDatepicker() {
        $('#deadline').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            language: 'ja', // 日本語ローカライズ
            beforeShowDay: function(date) {
                // 対象の日付の1日前を取得
                const targetDate = new Date(date);
                targetDate.setDate(targetDate.getDate() + 1); // 1日増やす

                // 'yyyy-mm-dd' 形式に変換
                const formattedDate = targetDate.toISOString().split('T')[0];
                console.log(formattedDate);

                // 日付が存在するかどうかを確認し、コンソールにログ出力
                const exists = availableDates.includes(formattedDate);
                console.log(`日付: ${formattedDate}, 存在する: ${exists}`);

                // 日付が存在する場合、ハイライトを適用
                if (exists) {
                    return {
                        classes: 'highlight', // ハイライト用クラスを追加
                        tooltip: 'データが存在します'
                    };
                }
                return {}; // 通常の日付には何も適用しない
            }
        });
    }
});

// 期限が近いタスクデータが存在する場合、データを取得して画面上にアラートで流す処理
$(function() {
    const deadlineData = $('#task-list-page');
    console.log(deadlineData);
    
    
    // サーバから期限が近いタスクデータを取得
    fetch('/task/notification')
        .then(response => {
            if (!response.ok) {
                throw new Error('ネットワークの応答が正常ではありませんでした');
            }
            return response.json();
        })
        .then(data => {
            console.log('期限が近いタスクデータ:', data);

            // メッセージと通知IDを一度のループで取得
            const messages = [];
            const notification_id = [];
        
            Object.entries(data).forEach(([message, id]) => {
                messages.push(message);           // メッセージを配列に追加
                notification_id.push(id);         // 通知IDを配列に追加
            });
        
            // メッセージが存在する場合はアラートを表示
            if (messages.length > 0) {
                const formattedMessages = messages.map(msg => `${msg}`);
                Swal.fire({
                    title: '期限が近いタスク',
                    text: `期限が近いタスク: ${formattedMessages}`,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                // alert(messages.join('\n'));
            }
        
            // 通知IDが存在する場合は削除関数を呼び出す
            if (notification_id.length > 0) {
                deleteTask(notification_id);
            }
        })
        .catch(error => console.error('Fetch error:', error));


        // タスク削除関数
        function deleteTask(notification_id) {
            notification_id.forEach(id => {
                fetch(`/task/${id}/notification_delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        console.error('レスポンスエラー:', response.status, response.statusText);
                        throw new Error('削除処理に失敗しました');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('削除成功:', data);
                })
                .catch(error => console.error('削除処理エラー:', error));
            });
        }        
});