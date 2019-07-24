<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyConsolidationRequestionActionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consolidation_request_action_details', function (Blueprint $table) {
             DB::statement("ALTER TABLE consolidation_request_action_details MODIFY action_status enum('cancelled','on_hold','consolidation','label_generated','shipped','combined','faulty','payment_pending','pickup','preparing') DEFAULT NULL");
            
              
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
