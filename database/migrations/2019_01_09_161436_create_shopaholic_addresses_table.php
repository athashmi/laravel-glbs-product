<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopaholicAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopaholic_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',40);
            $table->string('phone');
            $table->text('street');
            $table->string('city',255)->nullable();
            $table->string('state',30);
            $table->string('zip_code',30);
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('shopaholic_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopaholic_addresses');
    }
}
