<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnConsolidationCourierShippingCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consolidation_courier_shipping_charges', function (Blueprint $table) {
            $table->decimal('rate',8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('consolidation_courier_shipping_charges', function (Blueprint $table) {
            $table->decimal('rate',8,2);
        });
    }
}
