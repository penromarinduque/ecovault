<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;

class FileShareNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $fileId;
    public $userId;
    public $sharedBy;
    public $message;

    public function __construct(int $fileId, int $userId, int $sharedBy, string $message)
    {
        $this->fileId = $fileId;
        $this->userId = $userId;
        $this->sharedBy = $sharedBy;
        $this->message = $message;
    }

    public function via($notifiable): array
    {
        return ['broadcast', 'database'];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastWith(): array
    {
        return [
            'fileId' => $this->fileId,
            'userId' => $this->userId,
            'sharedBy' => $this->sharedBy,
            'message' => $this->message,
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'fileId' => $this->fileId,
            'userId' => $this->userId,
            'sharedBy' => $this->sharedBy,
            'message' => $this->message,
        ];
    }
}
