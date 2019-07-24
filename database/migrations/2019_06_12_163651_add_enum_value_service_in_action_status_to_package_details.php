<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnumValueServiceInActionStatusToPackageDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_details', function (Blueprint $table) {
             DB::statement("ALTER TABLE package_details MODIFY action_status enum('incomming','missing', 'found','sorted','split','picked','tested','returned','shipped', 'review','hold','damaged','service') DEFAULT 'sorted'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
