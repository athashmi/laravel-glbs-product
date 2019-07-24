<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnConsolidationGoodsDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('consolidation_goods_descriptions', function (Blueprint $table) {
            $table->enum('type',['battery','liquid'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('consolidation_goods_descriptions', function (Blueprint $table) {
            chema::dropIfExists('consolidation_goods_descriptions');
        });
    }
}
