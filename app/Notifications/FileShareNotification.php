<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;

class FileShareNotification extends Notification implements ShouldBroadcast
{
    public $fileId;
    public $userId;
    public $sharedBy;
    public $remarks;
    public $info;
    public function __construct(int $fileId, int $userId, int $sharedBy, string $remarks, string $info)
    {
        $this->fileId = $fileId;
        $this->userId = $userId;
        $this->sharedBy = $sharedBy;
        $this->remarks = $remarks;
        $this->info = $info;

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
            'message' => $this->remarks,
            'info' => $this->info,
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'fileId' => $this->fileId,
            'userId' => $this->userId,
            'sharedBy' => $this->sharedBy,
            'message' => $this->remarks,
            'info' => $this->info
        ];
    }
}