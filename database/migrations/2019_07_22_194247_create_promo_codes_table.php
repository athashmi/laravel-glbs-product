<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',50);
            $table->decimal('amount',8,2);
            $table->enum('type',['fixed','percentile']);
            $table->unsignedInteger('created_by'); 

            $table->unsignedInteger('object_id');  //valid for users/groups

            $table->enum('object_type',['shopaholic','group']);// either individual or group

            $table->enum('applicable_type',['courier','general']);// applicable for couriers or overall general applicable on subtotal(incase of percentage).group

            $table->json('applicable_ids')->nullable(); //couriers ids

            $table->enum('validity_cycle',['once','recurring'])->default('once');

            $table->date('valid_from')->nullable();
            $table->date('valid_till')->nullable();

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
        Schema::dropIfExists('promo_codes');
    }
}
