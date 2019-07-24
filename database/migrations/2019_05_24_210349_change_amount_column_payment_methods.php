<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAmountColumnPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_methods', function(Blueprint $table) {
            // $table->renameColumn('title', 'name');
            // $table->renameColumn('type', 'charges_type');
            // $table->renameColumn('amount', 'charges');
            // $table->renameColumn('icon', 'image_name');

            DB::statement('ALTER TABLE payment_methods CHANGE title name varchar(255)');
            DB::statement('ALTER TABLE payment_methods CHANGE amount charges decimal(8,2)');
            DB::statement('ALTER TABLE payment_methods CHANGE type charges_type enum("percentile", "fixed")');
            DB::statement('ALTER TABLE payment_methods CHANGE icon image_name varchar(255)');
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
