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
            $table->increments('productid');
            $table->string('category_id');
            $table->string('product_name');
            $table->text('product_description');
            $table->string('product_price');
            $table->text('location');
            
            $table->string('product_image_1')->nullable();
            $table->string('product_image_2')->nullable();
            $table->string('product_image_3')->nullable();
            $table->string('product_image_4')->nullable();
            
            $table->string('product_slug')->nullable();
            $table->string('short_description')->nullable();
            $table->string('product_type')->nullable();
            
            $table->string('manufacture_date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('is_deleted')->nullable();
            $table->integer('is_available')->nullable();
            
            $table->string('user_id');
            $table->timestamp('updated');
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
