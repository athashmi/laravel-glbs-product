<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;
use App\PackageImage;
use DataTables;
use App\OcrData;
use App\User;
use App\Shopaholic;

class PackageController extends Controller
{
    public function index(){
    	return view('packages.index');
    }

    public function getPackageList(){
    	$packages 	= Package::select('*');
     
		return DataTables::of($packages)
			->rawColumns(['action'])
			->addColumn('action', function ($package) {
				return view('packages.action-buttons', ['result' => $package, 'modal_id' => 'EditCountryModel'])->render();
			})->make(true);
    }
    public function create(){
    	return view('packages.add-package');
    }
    public function store(){
 
    	$packages = new Package();
    	$packages->package_id = rand(888888,1500000);
        //$packages->request_id = rand(888888,150000);
    	$packages->description = request()->description;
    	$packages->tracking_number = request()->tracking_number;
    	$packages->status = request()->status;
    	$packages->shopaholic_id = request()->shopaholic_id;
    	$packages->save();
    	$package_image = new PackageImage();
    	$package_image->image_name = request()->image_name;
        $package_image->type = 'package';
        $package_image->size_type = 'primary_thumbnail';
    	$package_image->package_id = $packages->id;
    	$package_image->save();
    	//["https:\/\/s3.amazonaws.com\/uploads-gshopaholics\/20180322110136_IMG_20180322_094737.jpg"]
    	return redirect()->route('package.index');
    }

 

   
}
