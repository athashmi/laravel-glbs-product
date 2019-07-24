<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnWalletRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('wallet_requests', function (Blueprint $table) {
             DB::statement('ALTER TABLE wallet_requests MODIFY type enum("deposit","withdrawal","offline_payment","refunded")');
              
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('wallet_requests', function (Blueprint $table) {
            //
        });
    }
}
