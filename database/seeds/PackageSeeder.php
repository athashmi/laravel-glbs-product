<?php

use Illuminate\Database\Seeder;
use App\Shopaholic;
use App\Package;
class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = DB::connection('mysql_old_data')->table('packages')
                        /*->where('id', '>', 17096)
                           ->limit(1)*/
                            ->get();

       	foreach ($packages as $key => $package) {
       		
       		$new_package = new Package;
            $new_package->package_id = $package->package_id;
            $new_package->tracking_number = $package->tracking_number;
           
           	$shopaholic = Shopaholic::where('sn','sn-'.$package->shopaholic_id)->first();

            $new_package->shopaholic_id = $package->shopaholic->id;

            if($package->description !='')
                 $new_package->description = $package->description;

            if($package->warehouse_shelf_id !='')
                $new_package->warehouse_shelf_id = $package->warehouse_shelf_id;

            $new_package->description = $package->package_description;
            

            $new_package->status = $package->status;
            
            $new_package->save();

       	}
    }
}
