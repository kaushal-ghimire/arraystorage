<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('bill_id');
            $table->unsignedBigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('quantity');
            $table->string('rate');
            $table->string('discount')->nullable();
            $table->string('total');
            $table->string('date');
            $table->integer('is_confirmed')->default(0); //0 order, 1 seen and processing, 2 delivered
            $table->string('confirmed_date',30)->nullable();
            $table->string('deliver_date',30)->nullable();
            $table->integer('confirmed_by')->nullable();
            // $table->integer('order_type')->default(0); // 0 web, 1 app
            // $table->unsignedBigInteger('product_created_by')->unsigned();
            // $table->foreign('product_created_by')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
