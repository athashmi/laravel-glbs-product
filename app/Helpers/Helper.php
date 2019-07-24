<?php
namespace App\Helpers;
use Carbon,Storage;
use Illuminate\Http\File;
use App\Option;

use Intervention\Image\ImageManager;

class Helper{

	public function manipulateAmount($balance) {
        if ($balance > 0) {
					return '<b> $' . $balance . ' USD </b>';
				}
                elseif($balance < 0)
				{
					return '<b class="lbl-red"> -$' . abs($balance) . ' USD </b>';
				}
                else {
					return '<b>$' . '0.00 USD </b>';
				}
    }

    public function formatDate($date){
        //dd($date);

        //Carbon::now()->format('D, d M Y H:i:s')

        return  Carbon::parse($date)->format('D, d  M  Y');

    	//return $carbon->isoFormat('Do MMMM YYYY');
    }

    /*public function formatDate($date){
        dd($date);
    	if(isset($date)){
    		return date('d M Y',strtotime($date));
    	}else{
    		return '';
    	}


    }*/

    public function dbConfigValue($name,$returnType)
    {
        $option = Option::where([
            ['module', '=', $name],
            ['key', '=', $returnType]
        ])->first();
        if($option)
        {
            return $option->value;
        }
    }

    public function paginatePerPage(){
        return 10;
    }

    public function h3AmountWithDollarAsSup($amount){
        return  '<h3 class="semi-bold"><sup>
                    <small class="semi-bold">$</small>
                    </sup> '.$amount.'</h3>';
    }
    public function chargesCount($consolidation,$rate){
        $rate = (float)$rate;
        foreach($consolidation->packages as $package){
            foreach($package->paidService as $key=>$service_req){
                $rate += (float)$service_req->services->amount;
            }
        }
        echo $rate;
    }


    function makePkgThumbnailAndUploadToS3($thumbnail_width,$image_url)
    {
        $image_name = basename($image_url);

        $thumb_name_random      = date('YmdHis').'_thumbnail_'.rand(0,1000).$image_name;

        $local_storage_folder = storage_path('app/'.config('constants.img_folder'));
        if(Storage::MakeDirectory($local_storage_folder, 0777, true,true)) {

        $ImageManager = new ImageManager();
        $ImageManager->make($image_url)

                     ->resize($thumbnail_width,null,function ($constraint) {
                            $constraint->aspectRatio();
                        })
                     ->save($local_storage_folder.'/'.$thumb_name_random,60);

        $s3_pkg_thumb_prefix = 'pkg_thumb/';

        $full_thumb_path = $s3_pkg_thumb_prefix.$thumb_name_random;




        $local_thumb_path = $local_storage_folder.'/' .$thumb_name_random;


        $path = Storage::disk('s3')->put($full_thumb_path, file_get_contents($local_thumb_path),'public');

        //$del = Storage::delete($local_thumb_path);
        unlink($local_thumb_path);
        //dd($local_thumb_path);
        return $s3_thumbnail_path = Storage::disk('s3')->url(config('filesystems.disks.s3.bucket').'/'.$full_thumb_path);
    }

    }

    function uploadToS3($image_url)
    {
        //$easypost_lablel_prefix = 'LabelEasyPostGlobalShopoaholicsNew/';

        $image_name     = basename($image_url);


        $image_unique =  date('YmdHis').'_s3_img_uploaded_'.rand(0,1000).$image_name;

         //$full_img_path = $image_unique;

//dd($image_unique);

        $gg = Storage::disk('s3')->put($image_unique, file_get_contents($image_url),'public');
        //dd('iii');
        //Storage::disk('s3')->put($full_img_path,new File($image_url));

        //if(file_exists($image_url))
           // unlink($image_url);

        // return  Storage::disk('s3')->url(config('filesystems.disks.s3.bucket').'/'.$full_img_path);
        return  Storage::disk('s3')->url(config('filesystems.disks.s3.bucket').'/'.$gg);
    }
}
