<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidationRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolidation_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_key',30);
            $table->json('address')->nullable();
            $table->enum('status',['preparing','payment_pending','processing','cancelled','on_hold','payment_due','shipped'])->default('preparing');
            $table->enum('type',['individual','parent','combined'])->default('individual');
            $table->enum('action_status',['pickup','faulty','none'])->default('none');
            $table->text('label_url')->nullable();
            $table->enum('cronjob_status',['label_generated','rate_calculated','none'])->default('none');
            $table->text('special_instructions')->nullable();
            $table->string('tracking_number',50)->nullable();
            $table->json('request_infos')->nullable();
            $table->json('goods_description_ids')->nullable();
            $table->text('remarks')->nullable();
            $table->string('domestic_tracking_number',250)->nullable();
            $table->string('domestic_tracking_type',250)->nullable();
            $table->string('parent_request_id',20)->nullable();
            $table->string('aes_itn_number',250)->nullable();
            $table->unsignedInteger('shopaholic_id')->nullable();
            $table->unsignedInteger('assigned_to')->nullable();
            $table->unsignedInteger('courier_id')->nullable();
            $table->unsignedInteger('payment_method')->nullable();
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
        Schema::dropIfExists('consolidation_requests');
    }
}
