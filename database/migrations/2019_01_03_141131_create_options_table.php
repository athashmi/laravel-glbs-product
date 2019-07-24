<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('options', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title', 200);
			$table->string('key', 250);
			$table->text('value');
			$table->unsignedInteger('user_id')->nullable();
			$table->timestamps();
			$table->enum('status', ['active', 'inactive'])->default('active');
		});

		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('options');
	}
}
