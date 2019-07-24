<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;


class ConsolidationLogEvent
{
    use  SerializesModels;
    public $data;
    public $flag;
    public $reason;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($consolidation,$flag,$reason = "")
    {
        $this->data = $consolidation;
        $this->flag = $flag;
        $this->reason = $reason;
    }
}
