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
            /** The bigIncrements method creates an auto-incrementing  UNSIGNED BIGINT (primary key) equivalent column  
                *$table->bigIncrements('id'); // or id()
                *The id method is an alias of the bigIncrements method. 
                *By default, the method will create an id column 
            */
            $table->id();

            /** The string method creates a VARCHAR equivalent column of the given length 
                * $table->string('name', 100); 
            */
            $table->string('name');

            /* The mediumText method creates a MEDIUMTEXT equivalent column */
            $table->mediumText('description');

            /**The float method creates a FLOAT equivalent column with the given precision 
                 (total digits) and scale (decimal digits)
                $table->float('amount', 8, 2);
             * */
            $table->float('price');
            $table->string('image');
            
            /** the timestamps method creates created_at and updated_at TIMESTAMP equivalent columns  */
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
