<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class PackageLogEvent
{
    use SerializesModels;
    public $data;
    public $prevStatus;
    public $status;
    public $request;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($package = "",$status = "",$prevStatus = "",$request="")
    {
        $this->data = $package;
        $this->status = $status;
        $this->prevStatus = $prevStatus;
         $this->request = $request;
    }

   
}
