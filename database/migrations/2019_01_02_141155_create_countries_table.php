<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('countries', function (Blueprint $table) {
			$table->increments('id');
			$table->string('iso', 2);
			$table->string('name', 50);
			$table->string('nice_name', 50);
			$table->string('iso3', 3)->nullable();
			$table->string('num_code', 100)->nullable();
			$table->string('phone_code', 100)->nullable();

			$table->timestamps();
			$table->tinyInteger('isK')->nullable();
		});
		

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('countries');
	}
}
