<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnPhoneLengthInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement('ALTER TABLE users MODIFY COLUMN phone VARCHAR(250)');

            DB::statement('ALTER TABLE users MODIFY COLUMN first_name VARCHAR(100)  Not NULL');
            DB::statement('ALTER TABLE users MODIFY COLUMN last_name VARCHAR(100) default NULL');

             
            //$table->string('phone', 250)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
