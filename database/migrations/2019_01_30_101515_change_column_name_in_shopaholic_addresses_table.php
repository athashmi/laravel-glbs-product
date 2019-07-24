<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNameInShopaholicAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopaholic_addresses', function (Blueprint $table) {
            DB::statement('ALTER TABLE shopaholic_addresses MODIFY name varchar(255) DEFAULT NULL');
             DB::statement('ALTER TABLE shopaholic_addresses MODIFY zip_code varchar(255) DEFAULT NULL');

            

             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shopaholic_addresses', function (Blueprint $table) {
            //
        });
    }
}
