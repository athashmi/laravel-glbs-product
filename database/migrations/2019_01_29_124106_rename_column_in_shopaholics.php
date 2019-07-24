<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnInShopaholics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopaholics', function (Blueprint $table) {

            DB::statement('ALTER TABLE shopaholics Change COLUMN reserved_warehouse_loc_id  reserved_warehouse_shelf_id INT');

           
             //$table->renameColumn('reserved_wharehouse_loc_id', 'reserved_wharehouse_shelf_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shopaholics', function (Blueprint $table) {
            //
        });
    }
}
