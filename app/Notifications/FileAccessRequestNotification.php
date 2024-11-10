<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\FileAccessRequests;
class FileAccessRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $request;
    public function __construct(FileAccessRequests $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('You have a new file access request.')
            ->line('File: ' . $this->request->file_name)
            ->line('Requested by: ' . $this->request->requestedByUser)
            ->line('Requested Permission: ' . $this->request->requested_permission)
            ->action('View Request', url('/file-request'));
    }
    public function toDatabase($notifiable)
    {
        // Database notification data
        return [
            'file_id' => $this->request->file_id,
            'requested_by_user_id' => $this->request->requested_by_user_id,
            'requested_permission' => $this->request->requested_permission,
            'status' => $this->request->status,
            'remarks' => $this->request->remarks,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'file_id' => $this->request->file_id,
            'requested_by_user_id' => $this->request->requested_by_user_id,
            'requested_permission' => $this->request->requested_permission,
            'status' => $this->request->status,
            'remarks' => $this->request->remarks,
        ];
    }
}
