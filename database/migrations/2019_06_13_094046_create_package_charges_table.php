<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->enum('action_type',['free','paid','other'])->default('free');
            $table->decimal('charges',8,2)->nullable();
            $table->unsignedInteger('package_id');
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
        Schema::dropIfExists('package_charges');
    }
}
