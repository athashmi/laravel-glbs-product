<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidationRequestActionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolidation_request_action_details', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('action_status',['cancelled','on_hold','consolidation','label_generated','shipped','combined','faulty','payment_pending','pickup']);
            $table->json('details')->nullable();
            $table->unsignedInteger('consolidation_request_id');
            $table->unsignedInteger('action_by');
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
        Schema::dropIfExists('consolidation_request_action_details');
    }
}
