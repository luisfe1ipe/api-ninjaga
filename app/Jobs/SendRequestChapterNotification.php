<?php

namespace App\Jobs;

use App\Models\RequestChapter;
use App\Models\User;
use App\Notifications\RequestChapterCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendRequestChapterNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected RequestChapter $requestChapter)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::whereHas('permissions', function ($query) {
            $query->whereIn('name', ['super-admin', 'admin']);
        })->get();

        if ($admins->isEmpty()) {
            Log::warning('Nenhum admin encontrado para notificar.');
            return;
        }

        Notification::send($admins, new RequestChapterCreated($this->requestChapter));
    }
}
