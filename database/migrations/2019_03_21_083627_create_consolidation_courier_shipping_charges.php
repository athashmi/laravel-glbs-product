<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidationCourierShippingCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolidation_courier_shipping_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('est_delivery_days');
            $table->decimal('shipping_rate_actual',8,2);
            $table->json('charges');
            $table->decimal('total',8,2);
            $table->unsignedInteger('consolidation_request_id');
            $table->unsignedInteger('courier_id');
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
        Schema::dropIfExists('consolidation_courier_shipping_charges');
    }
}
