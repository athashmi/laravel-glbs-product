<?php

namespace App\Listeners;

use App\Events\SplitPackageEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSplitPackageSMSNotification
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
     * @param  SplitPackageEvent  $event
     * @return void
     */
    public function handle(SplitPackageEvent $event)
    {
        //dd($event);
    }
}
