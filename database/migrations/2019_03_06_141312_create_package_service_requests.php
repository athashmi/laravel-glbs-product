<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageServiceRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_service_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->json('details')->nullable();
            $table->unsignedInteger('package_id');
            $table->unsignedInteger('package_service_id')->nullable();
            $table->unsignedInteger('assigned_to')->nullable(); //(employee/worker id from users table)
            $table->unsignedInteger('assigned_by')->nullable(); //(owner/admin id from users table)
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
        Schema::dropIfExists('package_service_requests');
    }
}
