<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopaholicsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('shopaholics', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->enum('type', ['ordinary', 'corporate']);
			$table->smallInteger('reserved_warehouse_loc_id')->nullable();
			$table->tinyInteger('logged_in')->default(0);
			$table->string('sn', 15);
			
			$table->softDeletes();
			$table->text('remarks')->nullable();
			//$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('shopaholics');

	}
}
