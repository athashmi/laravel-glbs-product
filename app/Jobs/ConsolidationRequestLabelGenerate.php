<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\SplitPackageNotification;
use Illuminate\Support\Facades\Notification;
use App\ConsolidationRequest;
use Config;
use Storage,Helper;


class ConsolidationRequestLabelGenerate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue,Queueable, SerializesModels;
    public $consolidation_id;
   // public $connection = 'database';
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->consolidation_id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
           $consolidation_request = ConsolidationRequest::where('id',$this->consolidation_id)->with('paymentDetail.shippingCharges.courier','boxDetail')->first();
             \EasyPost\EasyPost::setApiKey('y4HNPR7IVaSFphhKI2Ye3Q');
             $order = \EasyPost\Order::retrieve($consolidation_request->paymentDetail->shippingCharges->shipment_id);

            //     /*******
            //         Old EasyPost key 
            //         a2or0tDgk2I9MpLy3ZTmmQ
            //     *********/
           //     $order->buy(array("carrier" => 'USPS', "service" => 'ExpressMailInternational'));    

             $order->buy(array("carrier" => $consolidation_request->paymentDetail->shippingCharges->courier->name, "service" => $consolidation_request->paymentDetail->shippingCharges->courier->details->easy_post));
                $shipments = $order->__get('shipments');
                foreach ($shipments as $key => $value) {
                    $id = $value->__get('id');
                    $shipment = \EasyPost\Shipment::retrieve($id);
                    $shipment->insure(array('amount' => 1));
                    break;
                }
            $shipment_data = [];
            foreach ($order->shipments as $key => $shipment) {


                $image_url = Helper::uploadToS3($shipment['postage_label']['label_url']);
                //Storage::disk('s3')->put(config('filesystems.s3.url').config('filesystems.s3.bucket').'/LabelEasyPostGlobalShopoaholicsNew/'.time(), file_get_contents($shipment['postage_label']['label_url']));
                //$shipment_data['label'][] = $shipment['postage_label']['label_url'];

                $shipment_data['label'][] = $image_url;

     /*           Storage::disk('s3')->put(config('filesystems.s3.url').config('filesystems.s3.bucket').'/LabelEasyPostGlobalShopoaholicsNew/', file_get_contents($shipment['postage_label']['label_url']));
                $shipment_data['label'][] = $shipment['postage_label']['label_url'];
*/
                $shipment_data['tracking_number'][] = $shipment->tracking_code;
           }
           foreach ($consolidation_request->boxDetail as $key => $box) {
                $arr = [];
                $arr['shipment'][]['label_url'] = $shipment_data['label'][$key];
                $arr['shipment'][]['tracking_number'] = $shipment_data['tracking_number'][$key];
               $box->details = $arr;
               $box->update();
               unset($arr);
           }
    }
}
