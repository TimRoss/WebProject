<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('id')->references('id')->on('users');
            $table->integer('c')->nullable();
            $table->integer('java')->nullable();
            $table->integer('python')->nullable();
            $table->string('teamStyle')->nullable();
            $table->integer('twoHundreds')->nullable();
            $table->integer('threeHundreds')->nullable();
            $table->integer('fourHundreds')->nullable();
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
        Schema::drop('students');
    }
}
