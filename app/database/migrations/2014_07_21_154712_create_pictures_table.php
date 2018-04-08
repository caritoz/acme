<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePicturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pictures', function(Blueprint $table) {
			$table->increments('id');
			$table->string('caption');
			$table->string('short_desc');
			$table->integer('album_id')->unsigned();
            $table->string('path');
			$table->string('size_picture');
			$table->string('type_picture');
			$table->integer('order_picture');
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
		Schema::drop('pictures');
	}

}
