<?php

namespace App\Listeners;

use App\Events\ConsolidationLogEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ConsolidationRequestActionDetail;
use Auth;

class ConsolidationLogListener implements ShouldQueue
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
     * @param  ConsolidationLogEvent  $event
     * @return void
     */
    public function handle(ConsolidationLogEvent $event)
    {
        $old_pck_ids = [];
        $consolidation_detail = new ConsolidationRequestActionDetail();
        $consolidation_detail->consolidation_request_id = $event->data->id;
        $consolidation_detail->action_by = Auth::user()->id;
        switch ($event->flag) {
            case 'consolidation':
                $consolidation_detail->action_status    = 'consolidation';
                break;
            case 'cancelled':
                if($event->data->packages){
                    $old_pck_ids['package_ids'] = $event->data->packages->pluck('id')->toArray();
                    $old_pck_ids['reason'] = $event->reason;
                    $consolidation_detail->details      = $old_pck_ids;
                }

                $consolidation_detail->action_status    = 'cancelled';
                break;
            case 'payment_pending':
                $consolidation_detail->action_status    = 'payment_pending';
                break;
            case 'preparing':
                $consolidation_detail->action_status    = 'preparing';
                sleep(1);
                break;
            case 'on_hold':
                $consolidation_detail->action_status    = 'on_hold';
                break;
            case 'pickup':
                $consolidation_detail->action_status    =  'pickup';
                break;
            case 'processing':
                $consolidation_detail->action_status    =  'processing';
                break;
        }
        $consolidation_detail->save();
    }
}
