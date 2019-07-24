<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Docs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('docs', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title',250);
        $table->enum('type', ['developers', 'users']);
        $table->enum('category',['theme','js','frontend','ajax','database_info','socail_login','main_header']);
        $table->text('description')->nullable();
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
        Schema::dropIfExists('docs');
    }
}
