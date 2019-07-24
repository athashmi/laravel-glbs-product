<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnShopaholicCreditInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopaholic_credit_infos', function (Blueprint $table) {
            $table->unsignedSmallInteger('verified_by')->nullable();
            $table->enum('verified_through',['manual','authorize_net'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shopaholic_credit_infos', function (Blueprint $table) {
            chema::dropIfExists('shopaholic_credit_infos');
        });
    }
}
