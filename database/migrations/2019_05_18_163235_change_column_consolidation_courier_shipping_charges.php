<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnConsolidationCourierShippingCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('consolidation_courier_shipping_charges', function (Blueprint $table) {
           DB::statement('ALTER TABLE consolidation_courier_shipping_charges MODIFY est_delivery_days SMALLINT  DEFAULT NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
