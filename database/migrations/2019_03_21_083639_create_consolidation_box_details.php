<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidationBoxDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolidation_box_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('height',5,2);
            $table->decimal('width',5,2);
            $table->decimal('length',5,2);
            $table->decimal('actual_weight',5,2);
            $table->decimal('dimensional_weight',5,2);
            $table->enum('status',['shipped','pending','unshipped']);
            $table->unsignedInteger('consolidation_request_id');
            $table->unsignedInteger('consolidation_location_id');
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
        Schema::dropIfExists('consolidation_box_details');
    }
}
