<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** define Many to many relationship in database layer  by specifying 2 foreign keys from two tables 
         * Product and Category == > pivot table  */
        Schema::create('category_product', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('product_id')
                    ->references('id')
                    ->on('product')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('category_id')
                    ->references('id')
                    ->on('category')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('category_product');
    }
}
