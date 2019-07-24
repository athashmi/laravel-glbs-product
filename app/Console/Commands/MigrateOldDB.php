<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateOldDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gs_migrate:old_db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate old database into gs-live';

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
         $path = base_path('old_db');
            //$file_name = $this->argument('file_name');


            $file = $path.'/globalshop.sql';

            exec("mysql -u ".env('DB_USERNAME')." -p".env('DB_PASSWORD')." ".env('DB_DATABASE_OLD_DATA')." < $file");
        
    }
}
