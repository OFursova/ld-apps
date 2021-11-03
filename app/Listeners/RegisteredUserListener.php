<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\ListingMessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class RegisteredUserListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $admins = User::where('id', 1)->get();
        Notification::send($admins, new ListingMessageNotification('John Doe', 'john_doe@gmail.com', 'title', 'message'));
    }
}
