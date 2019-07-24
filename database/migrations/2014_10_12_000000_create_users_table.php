<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {

			$table->increments('id');
			$table->string('first_name', 100);
			$table->string('last_name', 100)->nullable();
			//$table->string('user_name', 70)->nullable();
			$table->string('email')->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->enum('status', ['active', 'inactive', 'pending'])->default('active');

			$table->smallInteger('country_id')->nullable();
			$table->string('phone', 15)->nullable();
			$table->enum('gender', ['male', 'female', 'other'])->default('male');
			$table->date('dob')->nullable();

			$table->string('picture', 255)->nullable();

			$table->string('password')->nullable();
			$table->enum('account_type', ['regular', 'facebook', 'twitter', 'google plus'])->default('regular');
			$table->string('social_login_id', 255)->nullable();
			$table->rememberToken();
			$table->timestamps();
		});



		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users');
	}
}
