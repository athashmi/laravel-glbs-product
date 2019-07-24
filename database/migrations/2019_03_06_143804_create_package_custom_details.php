<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageCustomDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_custom_details', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('object_type', ['package', 'consolidation_request'])->nullable();
            $table->string('hs_tariff_number',150)->nullable();
            $table->smallInteger('quantity')->nullable();
            $table->decimal('value',8 ,2)->nullable();
            $table->unsignedInteger('object_id')->nullable();
            $table->smallInteger('custom_category_id')->nullable();
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
        Schema::dropIfExists('package_custom_details');
    }
}
