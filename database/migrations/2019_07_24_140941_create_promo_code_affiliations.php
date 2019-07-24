<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodeAffiliations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_code_affiliations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('promo_code_id');
            $table->unsignedInteger('object_id');  //valid for users/groups

            $table->enum('object_type',['individual','group']);// either individual or group

            $table->json('details')->nullable();
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
        Schema::dropIfExists('promo_code_affiliations');
    }
}
