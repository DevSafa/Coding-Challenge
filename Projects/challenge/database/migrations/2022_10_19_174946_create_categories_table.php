<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            /** The id method is an alias of the bigIncrements method.  */
            $table->id();
            /** the name of category should be unique */
            $table->string('name')->unique();

            /** the timestamps method creates created_at and updated_at TIMESTAMP equivalent columns  */
            $table->timestamps();
         });
         
         /** add foreign key to the table after it's creation */
         Schema::table('categories', function (Blueprint $table)
         {
            /** Laravel also provides support for creating foreign key constraints, which are used to force referential integrity at the database level */

            /** nullable() Allow NULL values to be inserted into the column.  */
            /** define a parent_id column on the categories table that references the id column on a categories table */
            /** define self referencing relation  Category can have (null | catgory parent)  */
             $table->unsignedBigInteger('parent_id')->nullable();
             $table->foreign('parent_id')
                        ->references('id')
                        ->on('categories')
                        /** ON DELETE CASCADE means that if the parent record is deleted, any child records are also deleted  */
                        ->onDelete('cascade')
                        /** ON UPDATE CASCADE means that if the parent primary key is changed, the child value will also change to reflect that  */
                        ->onUpdate('cascade');
                 });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
