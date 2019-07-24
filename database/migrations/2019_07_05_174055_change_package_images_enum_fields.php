<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePackageImagesEnumFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_images', function(Blueprint $table) {
           DB::statement('ALTER TABLE package_images CHANGE size_type size_type enum("full", "thumbnail")');

           DB::statement('ALTER TABLE package_images CHANGE type type enum("primary", "secondary","inner_content","detial_photo")');

           $table->enum('status',['approved','rejected','pending'])->default('approved');

           $table->enum('upload_status',['manual','auto'])->default('auto');
           
       
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
