<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;

class SeedNewTablesOfOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gs_seed:tables {file_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'please provide full file name like file_name.sql';

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
     *
     * @return mixed
     */
    public function handle()
    {
         $filesInFolder  = \File::files(database_path('old-db-tables'));
        
         //dd(pathinfo($path));
            $path = database_path('old-db-tables');
            $file_name = $this->argument('file_name');

            if($file_name != 'globalshop.sql'):


            $file = $path.'/'.$file_name;
                
            $size = \File::size($file);

                //dd($size);

            $ext = pathinfo($file_name)['extension'];
            $tbl_name =  pathinfo($file_name)['filename'];
                

               

                if (!Schema::hasTable($tbl_name) && $ext == 'sql') {
                    if($size < 10000000):
                        DB::unprepared(file_get_contents($file));
                    else:

                    exec("mysql -u ".env('DB_USERNAME')." -p".env('DB_PASSWORD')." ".env('DB_DATABASE')." < $file");
                    endif;
                }
            endif;
               //$table  =  DB::statement("show tables like '$tbl_name' ");

               //dd($table);
               

                //
            
    }
}
