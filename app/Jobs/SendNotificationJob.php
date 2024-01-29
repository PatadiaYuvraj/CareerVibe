<?php

namespace App\Jobs;

use App\Notifications\SendNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private mixed $user;
    private string $msg;
    public function __construct(mixed $user, string $msg)
    {
        $this->user = $user;
        $this->msg = $msg;
    }

    public function handle(): void
    {
        Notification::send($this->user, new SendNotification($this->msg));
        Log::info('Notification sent to ' . $this->user->email);
    }
}
