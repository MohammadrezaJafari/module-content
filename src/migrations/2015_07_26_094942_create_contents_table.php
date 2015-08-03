<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('contents', function($table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('type');
            $table->text('description');
            $table->text('status');
            $table->integer('order');
            $table->text('attachment');
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
        Schema::drop('contents');
    }

}
