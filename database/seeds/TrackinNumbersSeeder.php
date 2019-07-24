<?php

use Illuminate\Database\Seeder;
use App\ExcelTrackingNumber;
class TrackinNumbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tracking_nums = DB::connection('mysql_old_data')->table('tracking_numbers')
                            ->where('tracking_number','!=',NULL)
                            ->get();
                           // dd($tracking_nums);


       foreach ($tracking_nums as $tracking_num) {


       	$new_tracking_num = new ExcelTrackingNumber;

       	$new_tracking_num->tracking_number = $tracking_num->tracking_number;
       	if($tracking_num->status==1)
       	$new_tracking_num->status = 'new';

       	if($tracking_num->status==2)
       	$new_tracking_num->status = 'processed';

       		$new_tracking_num->created_at = $tracking_num->created_at;
            $new_tracking_num->updated_at = $tracking_num->updated_at;

       	$new_tracking_num->save();
       }
    }
}
