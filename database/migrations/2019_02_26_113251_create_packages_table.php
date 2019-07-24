<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package_id',30);
            $table->text('description')->nullable();
            $table->string('tracking_number',250)->nullable();
            $table->enum('status', ['shipped', 'review','hold','sorted','returned','delivered'])->default('sorted');
            $table->enum('condition', ['damaged', 'prohibited'])->nullable();
            $table->json('free_services')->nullable();
            $table->unsignedInteger('consolidation_request_id')->nullable();
            $table->unsignedInteger('parent_package_id')->nullable();
            $table->unsignedInteger('shopaholic_id');
            $table->unsignedInteger('warehouse_shelf_id')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
