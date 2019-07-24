<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopaholicsInfosTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('shopaholics_infos', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('shopaholic_id');
			$table->string('ip_address', 40)->nullable();
			$table->string('device_type', 100)->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('shopaholics_infos');
	}
}
