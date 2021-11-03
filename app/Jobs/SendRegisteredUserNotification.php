<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ListingMessageNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SendRegisteredUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admins = User::where('id', 1)->get();
        Notification::send($admins, new ListingMessageNotification($this->user->name, $this->user->email, 'title', 'message'));
    }

    public function failed(\Throwable $exception)
    {
        info('Failed to process notification' . get_class($exception) . ' - '. $exception->getMessage());
    }
}
