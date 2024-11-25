<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\File;
use App\Models\User;
class FileShareNotification extends Notification implements ShouldBroadcast
{
    public $fileId;
    public $receiverId;
    public $senderId;
    public $remarks;
    public $notifyType;

    public function __construct(int $fileId, int $receiverId, int $senderId, string $remarks, string $notifyType)
    {
        $this->fileId = $fileId;
        $this->receiverId = $receiverId;
        $this->senderId = $senderId;
        $this->remarks = $remarks;
        $this->notifyType = $notifyType;

    }

    public function via($notifiable): array
    {
        return ['broadcast', 'database'];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->receiverId);
    }

    public function broadcastWith(): array
    {

        return [
            'fileId' => $this->fileId,
            'fileName' => File::find($this->fileId)->file_name ?? 'Unknown File',
            'receiverId' => $this->receiverId,
            'receiverName' => User::find($this->receiverId)->name ?? 'Unknown User',
            'senderId' => $this->senderId,
            'senderName' => User::find($this->senderId)->name ?? 'Unknown User',
            'message' => $this->remarks,
            'notifyType' => $this->notifyType,
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'fileId' => $this->fileId,
            'fileName' => File::find($this->fileId)->file_name ?? 'Unknown File',
            'receiverId' => $this->receiverId,
            'receiverName' => User::find($this->receiverId)->name ?? 'Unknown User',
            'senderId' => $this->senderId,
            'senderName' => User::find($this->senderId)->name ?? 'Unknown User',
            'message' => $this->remarks,
            'notifyType' => $this->notifyType,
        ];
    }
}