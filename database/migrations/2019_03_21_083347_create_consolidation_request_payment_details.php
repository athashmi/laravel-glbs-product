<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidationRequestPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolidation_request_payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('shipping_cost',8,2);
            $table->decimal('processing_charges',8,2);
            $table->json('processing_charges_details');
            $table->decimal('total_cost',8,2);
            $table->dateTime('paid_at');
            $table->unsignedInteger('consolidation_request_id');
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
        Schema::dropIfExists('consolidation_request_payment_details');
    }
}
