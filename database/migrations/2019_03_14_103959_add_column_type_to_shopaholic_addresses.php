<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTypeToShopaholicAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopaholic_addresses', function (Blueprint $table) {
             $table->enum('type',['primary','secondary'])->default('secondary');
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
