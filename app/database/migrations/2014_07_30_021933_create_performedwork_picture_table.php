<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePerformedworkPictureTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('performedwork_picture', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('performedwork_id')->unsigned()->index();
			$table->foreign('performedwork_id')->references('id')->on('performedworks')->onDelete('cascade');
			$table->integer('picture_id')->unsigned()->index();
			$table->foreign('picture_id')->references('id')->on('pictures')->onDelete('cascade');
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
		Schema::drop('performedwork_picture');
	}

}
