<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WalletRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('wallet_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 8, 2)->nullable();
            $table->enum('status', ['pending', 'processed','rejected'])->default('pending');
            $table->enum('type', ['deposit', 'withdrawal','offline_payment']);
            $table->unsignedInteger('processed_by')->nullable();
            $table->json('remarks')->nullable();
            $table->json('details')->nullable();
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('wallet_requests');
    }
}
