<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SplitPackageMail extends Mailable Implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $notifiable;
    public $users;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users,$notifiable){
        $this->notifiable = $notifiable;
        $this->users = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->markdown('emails.split.split_package',[
                  'package_service_request' => $this->notifiable,
                  'name' => $this->users->first_name.' '.$this->users->last_name,
                  ]);
    }
}
