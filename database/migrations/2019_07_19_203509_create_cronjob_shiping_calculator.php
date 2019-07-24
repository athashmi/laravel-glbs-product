<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronjobShipingCalculator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cronjob_shiping_calculator', function (Blueprint $table) {
            $table->increments('id');

            $table->string('esypst_id',200);

            $table->string('country',50);
             $table->decimal('rate_actual',8,2);
             $table->decimal('rate',8,2);
             $table->smallInteger('est_delivery_days')->nullable();

             $table->integer('weight')->nullable();

             $table->string('service',100)->nullable();

             $table->string('carrier',100)->nullable();

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
        Schema::dropIfExists('cronjob_shiping_calculator');
    }
}
