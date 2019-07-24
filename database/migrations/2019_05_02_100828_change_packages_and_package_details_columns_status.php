<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePackagesAndPackageDetailsColumnsStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {

             DB::statement("ALTER TABLE packages MODIFY status enum('incomming','missing','shipped', 'review','hold','sorted','returned','delivered') DEFAULT 'sorted'");
        });

        Schema::table('package_details', function (Blueprint $table) {

             DB::statement("ALTER TABLE package_details MODIFY action_status enum('incomming','missing', 'found','sorted','split','picked','tested','returned','shipped', 'review','hold','damaged') DEFAULT 'sorted'");
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
