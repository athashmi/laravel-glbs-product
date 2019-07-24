<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnCountryIdInShopaholicAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopaholic_addresses', function (Blueprint $table) {
            DB::statement('ALTER TABLE shopaholic_addresses MODIFY country_id INT DEFAULT NULL');
            //
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
