<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FileAccessNotification extends Notification
{
    use Queueable;
    public $fileId;
    public $receiverId;
    public $senderId;
    public $remarks;
    public $notifyType;
    public $status;

    public function __construct(int $fileId, int $receiverId, int $senderId, string $remarks, string $notifyType, string $status)
    {
        $this->fileId = $fileId;
        $this->receiverId = $receiverId;
        $this->senderId = $senderId;
        $this->remarks = $remarks;
        $this->notifyType = $notifyType;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
