<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopaholicFailedCreditcardTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopaholic_failed_creditcard_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->string('error_msg');
            $table->string('error_code');
            $table->string('payment_gateway');
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
        Schema::dropIfExists('shopaholic_failed_creditcard_transaction');
    }
}
