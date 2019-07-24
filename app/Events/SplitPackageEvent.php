<?php

namespace App\Events;

 
use Illuminate\Queue\SerializesModels;
 

class SplitPackageEvent
{
    use SerializesModels;
    public $service_request_obj;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($service_request_obj)
    {
        $this->service_request_obj = $service_request_obj;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
