<?php

namespace App\Notifications;

use App\Models\RequestChapter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestChapterCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected RequestChapter $requestChapter)
    {
        //
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
            ->line('Um novo capítulo foi solicitado.')
            ->action('Ver Solicitação', url('url-test'))
            ->line('Obrigado por usar nossa aplicação!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'requestChapterId' => $this->requestChapter->id,
            'chapter' => $this->requestChapter->chapter,
            'volume' => $this->requestChapter->volume,
            'projectId' => $this->requestChapter->project_id,
            'userId' => $this->requestChapter->user_id
        ];
    }
}
