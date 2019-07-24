<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableIndices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {

                DB::statement('ALTER TABLE users ADD INDEX user_index (id,first_name,last_name,email)');
            });

        Schema::table('shopaholics', function (Blueprint $table) {

                DB::statement('ALTER TABLE shopaholics ADD INDEX shopaholic_index (user_id,sn)');
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
