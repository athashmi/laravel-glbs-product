<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourierZonesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('courier_zones', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title', 20);
			// $table->enum('type', ['ups_saver', 'ups_express', 'ups_expedite', 'fedex_priority', 'fedex_economy', 'dhl']);

			 $table->enum('status', ['active', 'inactive'])->default('active');
			$table->json('country_ids');
			$table->unsignedInteger('courier_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('courier_zones');
	}
}
