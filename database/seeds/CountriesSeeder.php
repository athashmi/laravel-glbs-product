<?php

use Illuminate\Database\Seeder;
use App\Country;
//use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //$countries = DB::table('old_countries')->get();

      $countries = DB::connection('mysql_old_data')->table('countries')->get();
//dd( $countries);
       

       foreach ($countries as $country) {
       	$new_country = new Country;

       	$new_country->iso = $country->iso;
       	$new_country->name = $country->name;
       	$new_country->nice_name = $country->nicename;
       	$new_country->iso3 = $country->iso3;
       	$new_country->num_code = $country->numcode;
       	$new_country->phone_code = $country->phonecode;
       /*	$new_country->created_at = $country->created_at;
       	$new_country->updated_at = $country->updated_at;*/
       	if($country->isK)
       		$new_country->isK = 1;
       	else
       		$new_country->isK = 0;

       	$new_country->save();
       }


       $file_ = database_path('old-db-tables').'/country.txt';
        $file=fopen($file_,"r") or exit("Unable to open file!");

     

        foreach (file($file_,FILE_IGNORE_NEW_LINES)  as $line) {
            
            $arr = explode(',',$line);

            if($arr[0] != '' || $arr[0] != '-')
            $record = DB::table('countries')->where('iso',$arr[0])->first();

            //dd($record);
            if(!$record)
            {
                $ctry = new Country;
                $ctry->iso = $arr[0];
                $ctry->name = $arr[1];
                $ctry->nice_name = $arr[1];
                $ctry->save();
            }

            
           //dd($arr);
        }

       echo "Countries : Done";
    }


}
