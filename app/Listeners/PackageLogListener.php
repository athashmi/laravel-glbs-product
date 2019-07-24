<?php

namespace App\Listeners;

use App\Events\PackageLogEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\PackageDetail;
use Auth;


class PackageLogListener
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
     * @param  PackageLogEvent  $event
     * @return void
     */
    public function handle(PackageLogEvent $event)
    {
        $package_detail = new PackageDetail();
        switch ($event->status) {
            case 'missing':
                $package_detail->action_status    = 'missing';
                $package_detail->details = ['package_prev_status' => $event->prevStatus];
                break;
            case 'found':
                $package_detail->action_status    = 'found';
                break;
            // case 'payment_pending':
            //     $package_detail->action_status    = 'payment_pending';
            //     break;
            // case 'preparing':
            //     $package_detail->action_status    = 'preparing';
            //     sleep(1);
            //     break;
            // case 'on_hold':
            //     $package_detail->action_status    = 'on_hold';
            //     break;
             case 'picked':
                 $package_detail->action_status    =  'picked';
                 $package_detail->details       = ['cart'=>$event->request['cart'],
                                            'cart_section_color'=>$event->request['cart_section_color']];
            //     break;

        }
        $package_detail->package_id = $event->data->id;
        $package_detail->action_by  = Auth::user()->employee->id;
        $is_saved = $package_detail->save();
        $msg = [];
        if($is_saved){
            $msg['status'] = 1;
        }else{
            $msg['status'] = 0;
        }
        return $msg;
    }
}
