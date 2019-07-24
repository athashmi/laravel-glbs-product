<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidationGoodsDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolidation_goods_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',256);
            $table->text('description');
            $table->decimal('amount',8,2);
            $table->json('allowed_carriers');
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
        Schema::dropIfExists('consolidation_goods_descriptions');
    }
}
