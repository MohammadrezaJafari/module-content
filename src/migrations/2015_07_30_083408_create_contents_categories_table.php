<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('contents_categories', function($table)
        {
            $table->increments('id');

            $table->unsignedInteger('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('content_id')->unsigned();
            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });

        Schema::create('contents_tags', function($table)
        {
            $table->increments('id');

            $table->unsignedInteger('tag_id')->unsigned();
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('content_id')->unsigned();
            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });

        Schema::create('contents_menus', function($table)
        {
            $table->increments('id');

            $table->unsignedInteger('menu_id')->unsigned();
            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('content_id')->unsigned();
            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::drop('contents_categories');
        Schema::drop('contents_menus');
        Schema::drop('contents_tags');
    }

}
