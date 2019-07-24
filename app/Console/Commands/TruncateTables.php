<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use File;
use App\Country;

class TruncateTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gs_truncate:tables {tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'truncate tables specified in handle. options 
    --- shopaholics will empty tables (users,shopaholics,shopaholic_addresses,shopaholics_infos)
    ---- permissions will truncate table(permissions)
    ---- roles will truncate table(roles)
    ---- courier_zones will truncate table(courier_zones)
    ---- couriers will truncate table(couriers)
    ---- courier_rates will truncate table(courier_rates)
    ---- options will truncate table(options)
    ---- warehouse_shelves will truncate table(warehouse_shelves)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *dfdf
     * @return mixed
     */
    public function handle()
    {
       $option = $this->argument('tables');

          $TablesArr = strpos($option, ',');

          if($TablesArr):

               $options = explode(',', $option);

              // dd($options);
               if(is_array($options)):

                foreach ($options as $tbl) {
                    $this->truncateTable($tbl);
                }

                dd('ok');
               endif;
           endif;
       


       if($option== 'countries')
        $this->truncatecountriesData();

       if($option== 'shopaholics')
        $this->truncateShopaholicsData();

        if($option== 'permissions')
            $this->truncatePermissionsData();

         if($option== 'roles')
            $this->truncateRolesData();

        if($option== 'courier_zones')
            $this->truncateCourierZonesData();

        if($option== 'couriers')
            $this->truncateCouriersData();


        if($option== 'courier_rates')
            $this->truncateCourierRatesData();

         if($option== 'options')
            $this->truncateOptionsData();

         if($option== 'warehouse_shelves')
            $this->truncateWarehouseShelvesData();
             
       
        if($option== 'all'):
            $this->truncateShopaholicsData();
            $this->truncatePermissionsData();
            $this->truncateRolesData();
            $this->truncateCourierZonesData();
            $this->truncateCouriersData();
            $this->truncateCourierRatesData();

            $this->truncateOptionsData();
            $this->truncateWarehouseShelvesData();
            $this->truncatecountriesData();
            $this->truncateWarehousesData();
        endif;
        
        
        
        //B::statement("TRUNCATE TABLE users");
    }

    function truncateTable($tbl){

         DB::statement("TRUNCATE TABLE $tbl");
    }

    function truncateShopaholicsData(){

        DB::statement("TRUNCATE TABLE users");
        DB::statement("TRUNCATE TABLE shopaholics");
        DB::statement("TRUNCATE TABLE shopaholic_addresses");
        DB::statement("TRUNCATE TABLE shopaholics_infos");
        DB::statement("TRUNCATE TABLE shopaholic_credit_infos");
        DB::statement("TRUNCATE TABLE shopaholic_failed_transactions");

        DB::statement("TRUNCATE TABLE role_user");
        DB::statement("TRUNCATE TABLE wallet_transactions");
        DB::statement("TRUNCATE TABLE wallet_requests");

    }

     function truncatePermissionsData(){

      DB::statement("TRUNCATE TABLE permissions");
    }


     function truncateRolesData(){

        DB::statement("TRUNCATE TABLE roles");
    }

     function truncateCourierZonesData(){

        DB::statement("TRUNCATE TABLE courier_zones");
        
    }

     function truncateCouriersData(){

        DB::statement("TRUNCATE TABLE couriers");
        
        
    }

     function truncateCourierRatesData(){

        DB::statement("TRUNCATE TABLE courier_rates");
        
    }

     function truncateOptionsData(){

        DB::statement("TRUNCATE TABLE options");
        
    }

     function truncateWarehouseShelvesData(){

        DB::statement("TRUNCATE TABLE warehouse_shelves");
        
    }

    function truncateWarehousesData(){

        DB::statement("TRUNCATE TABLE warehouses");
        
    }



     function truncatecountriesData(){

        DB::statement("TRUNCATE TABLE countries");
        
    }

    
}
