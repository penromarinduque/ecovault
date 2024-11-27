<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\File;
use App\Models\User;

class FileAccessNotification extends Notification implements ShouldBroadcast
{
    //use Queueable;
    public $fileId;
    public $receiverId;
    public $senderId;
    public $remarks;
    public $notifyType;
    public $status;
    public $recipient;

    public $fileName;
    public $receiverName;
    public $senderName;

    public function __construct(
        int $fileId,
        ?int $receiverId,
        int $senderId,
        string $remarks,
        string $notifyType,
        string $status,
        string $recipient
    ) {
        $this->fileId = $fileId;
        $this->receiverId = $receiverId === 'admin' ? null : $receiverId;
        $this->senderId = $senderId;
        $this->remarks = $remarks;
        $this->notifyType = $notifyType;
        $this->status = $status;
        $this->recipient = $recipient;

        // Preload related data
        $this->fileName = File::find($fileId)->file_name ?? 'Unknown File';
        $this->receiverName = $this->receiverId
            ? User::find($this->receiverId)->name ?? 'Unknown User'
            : 'Admin Group';
        $this->senderName = User::find($senderId)->name ?? 'Unknown User';
    }

    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }


    public function broadcastOn(): PrivateChannel
    {
        if ($this->recipient === 'admin') {
            return new PrivateChannel("admin.notifications");
        }
        return new PrivateChannel('user.' . $this->receiverId);


    }
    public function broadcastWith(): array
    {

        return [
            'fileId' => $this->fileId,
            'fileName' => $this->fileName,
            'receiverId' => $this->receiverId,
            'receiverName' => $this->receiverName,
            'senderId' => $this->senderId,
            'senderName' => $this->senderName,
            'message' => $this->remarks,
            'notifyType' => $this->notifyType,
            'status' => $this->status,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->broadcastWith();
    }
}
