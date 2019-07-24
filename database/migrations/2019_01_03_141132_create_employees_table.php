<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employees', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('user_id');
			$table->unsignedInteger('managed_by')->nullable();
			// $table->date('birth_date');
			$table->string('time_zone', 150)->nullable();
			$table->date('hire_date');
			$table->enum('pay_type', ['monthly', 'hourly', 'contract'])->default('hourly');
			$table->float('pay_rate', 8, 2);
			$table->smallInteger('vacation_yearly')->nullable();
			$table->smallInteger('sick_leave')->nullable();
			$table->string('emergency_contact_name', 50)->nullable();
			$table->string('emergency_contact_phone', 15)->nullable();
			$table->text('address')->nullable();
			//$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->json('selfs')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('employees');
	}
}
