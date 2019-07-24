<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DeleteTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gs_delete:tables {prefix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Provide the tables prefix like package_';

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
        //dd($this->argument('prefix'));
        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table)
        {
             dd($table);
        }
    }
}
