<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('package_id');
            $table->enum('action_status', ['missing', 'found','split','picked','tested','returned'])->nullable();
            $table->json('details')->nullable();
            $table->unsignedInteger('package_service_id')->nullable();
            $table->unsignedInteger('action_by')->nullable(); //[primary key id of table users]
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
        Schema::dropIfExists('package_details');
    }
}
