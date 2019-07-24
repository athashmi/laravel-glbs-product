<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('warehouses', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 50);
			$table->string('street', 191);
			$table->string('city', 40);
			$table->string('state', 30);
			$table->string('phone', 30);
			$table->string('email', 191);
			$table->enum('status', ['active', 'inactive'])->default('active');
			$table->unsignedInteger('country_id');
			//  $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//Schema::dropIfExists('warehouses');
	}
}
