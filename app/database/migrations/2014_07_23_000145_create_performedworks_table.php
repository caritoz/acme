<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePerformedworksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('performedworks', function(Blueprint $table) {
			$table->increments('id');
			$table->string('caption');
			$table->text('summary')->nullable();
			$table->text('description')->nullable();
			$table->date('work_date')->nullable();
            $table->integer('visits')->nullable();
			$table->boolean('active')->default(1);
			$table->boolean('published')->default(0);
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
		Schema::drop('performedworks');
	}

}
