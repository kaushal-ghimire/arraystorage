<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_id');
            $table->string('total');
            $table->string('discount')->nullable();
            $table->string('grand_total');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('date', 15);
            $table->integer('received')->nullable();
            $table->string('delivery_location');
            $table->string('is_active')->default(1);
            $table->integer('is_confirmed')->default(0); //0 order, 1 seen, 2 process for delivery, 3 delivered
            // $table->integer('order_type')->default(0); // 0 from backend, 1 from app
            $table->unsignedBigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('order_details');
    }
}
