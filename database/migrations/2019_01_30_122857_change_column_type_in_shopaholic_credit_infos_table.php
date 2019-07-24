<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypeInShopaholicCreditInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopaholic_credit_infos', function (Blueprint $table) {
             DB::statement('ALTER TABLE shopaholic_credit_infos MODIFY type enum("visa","master","american","discover","other") DEFAULT "other"');

              DB::statement('ALTER TABLE shopaholic_credit_infos MODIFY status enum("verified","unverified","blocked") DEFAULT "unverified"');
              DB::statement('ALTER TABLE shopaholic_credit_infos MODIFY digit varchar(6)');

              
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
            //
        });
    }
}
