<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnConsolidationCourierShippingChargeIdToTableConsolidationRequestPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consolidation_request_payment_details', function (Blueprint $table) {

            $table->unsignedInteger('consolidation_courier_shipping_charge_id')->nullable();
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
        Schema::table('table_consolidation_request_payment_details', function (Blueprint $table) {
            //
        });
    }
}
