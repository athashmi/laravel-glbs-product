<?php

use Illuminate\Database\Seeder;
use App\WarehouseShelf;
use App\Warehouse;

class warehouseShelvesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $w_shelves_package = DB::connection('mysql_old_data')->table('warehouse_self')->get();

       $active_warehouse  = Warehouse::where('status','active')->first();

       foreach ($w_shelves_package as $w_shelf) {
       		
       		$shelf = new WarehouseShelf;

       		$shelf->name = $w_shelf->name;

       		if($w_shelf->is_full):
       			$shelf->status = 'full';
          else:
            $shelf->status = 'partially_full';
       		endif;
       			$shelf->warehouse_id = $active_warehouse->id;
       		$shelf->save();
       }

       $w_shelves_consolidated = DB::connection('mysql_old_data')->table('self_colors')->get();


       foreach ($w_shelves_consolidated as $w_shelf) {
          
          $shelf = new WarehouseShelf;

          $shelf->name = $w_shelf->self;

           $shelf->color = strtolower($w_shelf->color);

            $shelf->usage_type = 'consolidated';

          
            $shelf->warehouse_id = $active_warehouse->id;
          $shelf->save();
       }

       echo "WarehouseShelves : Done";
    }
}
