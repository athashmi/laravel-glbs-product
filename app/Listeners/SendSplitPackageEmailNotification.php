<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\SplitPackageEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SplitPackageNotification;
use Auth;

class SendSplitPackageEmailNotification implements ShouldQueue
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
        Notification::send($event->service_request_obj, new SplitPackageNotification(Auth::user()));
    }
}
