<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('product_id');
            $table->string('name');
            $table->string('size')->nullable(true);
            $table->string('color')->nullable(true);
            $table->string('image')->nullable(true);
            $table->integer('purchased_quantity');
            $table->string('unit');
            $table->integer('purchase_price');
            $table->integer('vat')->nullable(true);
            $table->integer('purchased_price');
            $table->integer('sell_quantity');
            $table->integer('margin')->nullable(true);
            $table->integer('delivery_charge')->nullable(true);
            $table->integer('discount')->nullable(true);
            $table->double('selling_price');
            $table->longText('description')->nullable(true);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('categories_id')->nullable(true);
            $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('subcategories_id')->nullable(true);
            $table->foreign('subcategories_id')->references('id')->on('subcategories')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('maincategories_id')->nullable(true);
            $table->foreign('maincategories_id')->references('id')->on('maincategories')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('units_id');
            $table->foreign('units_id')->references('id')->on('units')->onDelete('cascade');
            $table->unsignedBigInteger('suppliers_id')->nullable(true);
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->unsignedBigInteger('bills_id')->nullable(true);
            $table->foreign('bills_id')->references('id')->on('bills')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}