<?php

use Illuminate\Database\Seeder;
use App\Warehouse;

class WharehosesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouses = [
			[
				'name' => 'Global Shopaholics',
				'street' => '601 Cornell Drive Unit G11',
				'city' => 'Wilmington',
				'state' => 'Delaware',
				'phone' =>'786-540-4747',
				'email' =>'abc@test.com',
				'status' =>'active',
				'country_id' => 226,
				'zip_code' => 19801,
			]
			
		];

		foreach ($warehouses as $warehouse) {
			Warehouse::create($warehouse);
		}
		echo "Warehouses : Done";
    }
}
