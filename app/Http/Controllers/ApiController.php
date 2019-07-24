<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ConsolidationRequest;
use App\Option;
use App\Package;
use App\PackageImage;
use App\WarehouseShelf;
use App\PackageDetail;
use Helper,Storage;
class ApiController extends Controller
{

	 function uploadImages() {
	 	/*$storage_path =storage_path('app');
	 	dd($storage_path);*/

	 	/*try {
			 		$tt  = Storage::disk('s3')->put('skfjdskjjsdfkj.jpeg', file_get_contents('/var/www/html/gs-production/storage/app/public/images/20190712174725_thumbnail_188.jpeg'));
			 	//dd('kkkk');

			 	}
			 	catch(Exception $e) {
		  echo 'Message: ' .$e->getMessage();
		}*/

			$resposeData = array();

    	$tracking_numbers = trim($_POST['tracking_number']);
    	$enteredManually  = trim($_POST['scan_manually']);
    	$images		      = $_FILES['images'];

    	if(!$package = Package::where('tracking_number', $tracking_numbers)->first()){
	    	$seprator = "";
	    	if(strpos($tracking_numbers, $seprator) !== false){
	    		$tracking_numbers   = substr($tracking_numbers, strpos($tracking_numbers, $seprator) + 1);
	    		if(strlen($tracking_numbers) > 22) {
	    			$tracking_numbers = substr($tracking_numbers, 0, 22);
	    		}
	    	}
	    	if(strpos($tracking_numbers, '42019801') !== false) {
	    		$tracking_numbers = str_replace('42019801', '',$tracking_numbers);
	    		if(strlen($tracking_numbers) > 22) {
	    			$tracking_numbers = substr($tracking_numbers, 0, 22);
	    		}
	    	}
		}

		$package = Package::where('tracking_number', 'like', '%'.$tracking_numbers.'%')
							//->with()
							->first();

	    if($package){
	    	if($package->status != 'missing'){
		    	/*$picture_links = json_decode($package->picture_links, true);
		    	$thumbnail_picture_links = json_decode($package->thumbnail_picture_links, true);*/
		    	if (request()->hasFile('images')):

				    $file = request()->file("images");
			    	//$imgPath = $images['name'];
					//$tmpPath = $images['tmp_name'];

				  $img_name	= date("Ymdhis"). '.' . $file->guessExtension();
					$thumbnail_img_name 	= date('YmdHis').'_thumbnail_'.rand(0,1999) .'.' . $file->guessExtension();



					$thumbnail_width = Helper::dbConfigValue('global','thumbnail_size');

					$image_saved = $file->storeAs(config('constants.img_folder'), $thumbnail_img_name);

					$storage_path =storage_path('app').'/';

					$img_path = $storage_path.$image_saved;

   				$s3_img_path = Helper::uploadToS3($img_path);
					// dd($s3_img_path);

					$s3_thumbnail_path = Helper::makePkgThumbnailAndUploadToS3($thumbnail_width,$img_path);




	        			$package_thumb = new PackageImage();
			            $package_thumb->image_name    =  $s3_thumbnail_path;
			            $package_thumb->size_type     =  'thumbnail';
			            $package_thumb->type          =  'inner_content';
			            $package_thumb->package_id    =  $package->id;


			            $package_image = new PackageImage();
			            $package_image->image_name    =  $s3_img_path;
			            $package_image->size_type     =  'full';
			            $package_image->type          =  'inner_content';
			            $package_image->package_id    =  $package->id;

	        		if($enteredManually == 1){

			            $package_image->upload_status =	'manual';
			            $package_image->status 		  = 'pending';
			            $package_image->save();
            			
            			$package_thumb->upload_status =	'manual';
			            $package_thumb->status 		  = 'pending';
			            $package_thumb->save();
   


		    		} else {
		    			$package_thumb->save();
		    			$package_image->save();

		    		}


		        $resposeData['success'] = true;
			    	$resposeData['msg'] = "Uploaded Successfully";
			    endif;
			}else  {
				$resposeData['success'] = false;
			    $resposeData['msg'] = "Package not found";
			}
    	}else{
    		$resposeData['success'] = false;
		    $resposeData['msg'] = "Invalid Tracking Number";
    	}
        return json_encode($resposeData);
    }


}
