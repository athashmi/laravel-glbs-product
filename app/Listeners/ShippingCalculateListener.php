<?php

namespace App\Listeners;

use App\Events\ShippingCalculateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShippingCalculateListener
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
     * @param  ShippingCalculateEvent  $event
     * @return void
     */
    public function handle(ShippingCalculateEvent $event)
    {
        //
    }
}
