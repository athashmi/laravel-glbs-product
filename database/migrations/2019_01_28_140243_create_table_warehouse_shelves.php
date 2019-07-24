<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWarehouseShelves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_shelves', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name',50);
            $table->enum('status',['full','partially_full','empty'])->default('empty');

            $table->enum('usage_type',['package','consolidated'])->default('package');

             $table->enum('color',['none','orange','red','green','purple','black','pink','yellow','blue','brown','white'])->default('none');

           $table->unsignedInteger('warehouse_id');


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
        Schema::dropIfExists('warehouse_shelves');
    }
}
