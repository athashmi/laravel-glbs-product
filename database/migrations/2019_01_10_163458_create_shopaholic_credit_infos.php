<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopaholicCreditInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopaholic_credit_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('first_transec_amount',6, 2)->nullable();
            $table->decimal('second_transec_amount',6, 2)->nullable();
            $table->smallInteger('digit');
            $table->smallInteger('attempt')->default('0');
            $table->enum('status', ['verified', 'unverified'])->default('unverified');
            $table->enum('type', ['visa', 'master'])->default('visa');
            $table->unsignedInteger('shopaholic_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopaholic_credit_infos');
    }
}
