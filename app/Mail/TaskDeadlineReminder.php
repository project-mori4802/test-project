<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Task; // Taskモデルをインポート


class TaskDeadlineReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $task; // タスク情報を保持するプロパティ

    /**
     * 新しいインスタンスを生成します。
     *
     * @param Task $task
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task; // コンストラクタでタスクを受け取る
    }

    /**
     * メールのビューテンプレートを指定します。
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('タスク締切のお知らせ') // メールの件名を設定
                    ->view('emails.task_deadline_reminder') // ビューテンプレートを指定
                    ->with(['task' => $this->task]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Deadline Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.task_deadline_reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
