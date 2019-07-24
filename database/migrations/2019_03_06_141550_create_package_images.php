<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_name',256)->nullable();
            $table->enum('size_type',['full_image','thumbnail','primary_full','primary_thumbnail'])->nullable();
            $table->enum('type',['package','consolidated','package_item'])->nullable();
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
        Schema::dropIfExists('package_images');
    }
}
