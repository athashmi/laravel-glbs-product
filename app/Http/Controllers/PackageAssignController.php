<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Package;
use App\PackageImage;
use App\PackageDetail;
use DataTables;
use App\OcrData;
use App\User;
use App\Shopaholic;
use App\ExcelTrackingNumber;
use App\WarehouseShelf;

use Excel,Auth,Helper,Image,Storage,Config,DB;
use Intervention\Image\ImageManager;

class PackageAssignController extends Controller
{
    public function index(){

      //$qry = OCRData::latest()->where('status', 'ASSIGNED')->limit(200)
             // ->toSql()
        //         ->update(array('status' => 'UNASSIGNED'))
          //      ;
        //dd($qry);


        $unassigned_package = OcrData::where('status','UNASSIGNED')->paginate(1);


        if($unassigned_package->count()>0):


            $item = $unassigned_package->items()[0];
           // dd($item);
            $shopaholics = collect(json_decode($item->shopaholics));

            $tracking_numbers = collect(json_decode($item->tracking_numbers));

            $users = [];

            if($shopaholics->count()>0):
                foreach ($shopaholics as $shopaholic):

                    $users[] = User::whereHas('shopaholic',function($q) use($shopaholic){
                                $q->where('sn','sn-'.$shopaholic->id);
                            })
                            ->with('shopaholic')
                            ->first();

            //echo '<input type="radio" name="" class="m-l-5 p-5 m-r-5" value=""> '.$shopaholic->first_name.' '.$shopaholic->last_name.' <b>('..'</b>)';

        endforeach;
        endif;

        $package_exists = true;

        return view('packages.ocr.unassigned',compact('unassigned_package','item','users','tracking_numbers','package_exists'));

    else:
        $package_exists = false;
        return view('packages.ocr.unassigned',compact('package_exists'));
    endif;

    }

    function getShopaholicsForOcr()
    {
        //dd(request()->all());
        $keyword = urldecode(request()->term);

        //dd($keyword);

        if($keyword != ''):

            $shopaholics = Shopaholic::where('sn', 'LIKE', '%' . $keyword . '%')
                                ->orWhereHas('user', function($query) use ($keyword) {

                                  $query->where("first_name",'like','%'.$keyword.'%')
                                   ->orWhere("last_name",'like','%'.$keyword.'%')
                                    
                                    //firstname space lastname
                                   ->orWhere(DB::raw("CONCAT(`first_name`,' ',`last_name`)"),'like','%'.$keyword.'%')

                                   // firstname lastnaem without space
                                   ->orWhere(DB::raw("CONCAT(`first_name`,'',`last_name`)"),'like','%'.$keyword.'%')

                                   // if someone has put lastname first on label and firstname as second with space
                                   ->orWhere(DB::raw("CONCAT(`last_name`,' ',`first_name`)"),'like','%'.$keyword.'%')

                                   // if someone has put lastname first on label and firstname as second without space
                                   ->orWhere(DB::raw("CONCAT(`last_name`,'',`first_name`)"),'like','%'.$keyword.'%')

                                    ->orWhere("email",'like','%'.$keyword.'%');
                                })

                            ->with('user')
                            ->limit(15)
                            ->get();

        else:
           $shopaholics = Shopaholic::with('user')
                                    ->limit(10)
                                    ->get();
        endif;


        $keyed = $shopaholics->mapWithKeys(function ($item) {
                    return [$item['id'] => ['id'=>$item['id'],
                                            'text'=> $item['user']['first_name'].' '.$item['user']['last_name'].' ('.strtoupper($item['sn']).')'
                                            ]
                            ];
                });

       $result = array_values($keyed->toArray());


        return json_encode($result);

    }

    function trackingNumberAutoComplete()
    {
    	//dd(request()->all());
    	$term = request()->term;

    	$tracking_num = ExcelTrackingNumber::where('tracking_number','like','%'.$term)
    									->where('status','new')
    									->pluck('tracking_number');
    									//->first();
    									//dd($tracking_num);

    	return json_encode($tracking_num);
    }

    function importTrackingNumbers()
    {
    	 $validatedData = request()->validate([
            'excelSheet' => 'required',

        ]);
    	//dd('ffff');
        //OCRData::where('status', 'NOTASSIGNED')->update(array('status' => 'PENDING'));
        $excel_data = Excel::toArray(new ExcelTrackingNumber,request()->file('excelSheet'));
        $full_data = [];
        foreach ($excel_data[0] as $key => $value) {
            if($value[0] == 'trackingnumber')continue;
            if (trim($value[0]) != '420198015789' && trim($value[0]) !== '42019801999' && count(explode(" ", trim($value[0]))) == 1) {
                ExcelTrackingNumber::where('tracking_number', trim($value[0]))->delete();
                $trackingNumber = new ExcelTrackingNumber;
                $trackingNumber->tracking_number = $value[0];

                $trackingNumber->save();
            }
        }
        return back();
    }

    function assign()
    {



//dd(config('filesystems.disks.s3'));



    	$data = [];
        $validate_data = [];
        $shopaholic_select     = request()->shopaholic_select;
    	$tracking_number_input = request()->tracking_number_input;
        $tracking_radio_input  = request()->tracking_radio_input;
    	if($shopaholic_select == '')
    	{
            $validate_data['shopaholic_select'] = 'required';
    	}
    	if(($tracking_number_input == '' && $tracking_radio_input == '') && $shopaholic_select != '')
    	{
            $validate_data['tracking_number_input'] = 'required';
    	}
        request()->validate($validate_data);
        if(!empty($tracking_number_input)){
            $data['tracking_number'] =  $tracking_number_input;
        }else{
            $data['tracking_number'] =  $tracking_radio_input;
        }

        $shelf = WarehouseShelf::where('name',request()->pkg_location)->first();
        if($shelf)
        {
            $shelf_id = $shelf->id;
        }
        else{
            $shelf                = new WarehouseShelf();
            $shelf->name          = request()->pkg_location;

            $shelf->usage_type    = 'package';

            $shelf->color     = 'none';
            $shelf->status    = 'partially_full';
            $shelf->save();
            $shelf_id = $shelf->id;
        }


        $package                    =  new Package();
        $package->package_id        =  'PKG-'.bin2hex(random_bytes(5)).time();
        $package->tracking_number    =  $data['tracking_number'];
        $package->status             =  'sorted';
        $package->warehouse_shelf_id =  $shelf_id;
        $package->shopaholic_id      =  $shopaholic_select;
        $pkg_saved                   =  $package->save();

        $package_action = new PackageDetail;
        $package_action->package_id = $package->id;
        $package_action->action_status = 'sorted';
        $package_action->action_by = Auth::user()->id;
        $package_action->save();

        $ocr_data = OcrData::where('id',request()->ocr_data_id)->update(['status' => 'ASSIGNED']);




        /*** make thumbnail**********/
            $image_url     = request()->img_url;

            $thumbnail_width = Helper::dbConfigValue('global','thumbnail_size');

            $s3_thumbnail_path = Helper::makePkgThumbnailAndUploadToS3($thumbnail_width,$image_url);



        /**** end thumbnail **********/


        //dd($s3_thumbnail_path);
        if($pkg_saved){
            $package_image = new PackageImage();
            $package_image->image_name    =  $s3_thumbnail_path;
            $package_image->size_type     =  'thumbnail';
            $package_image->type          =  'primary';
            $package_image->package_id    =  $package->id;
            $img_saved                    =  $package_image->save();

            $package_image = new PackageImage();
            $package_image->image_name    =  request()->img_url;
            $package_image->size_type     =  'full';
            $package_image->type          =  'primary';
            $package_image->package_id    =  $package->id;
            $img_saved                    =  $package_image->save();
        }
        session()->push('msg', 1);
        return redirect()->back();
    }

}
