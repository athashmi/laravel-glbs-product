<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_details', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->enum('end_status',['auto_closed','task_ended'])->default('task_ended');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('task_id');
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
        Schema::dropIfExists('task_details');
    }
}
