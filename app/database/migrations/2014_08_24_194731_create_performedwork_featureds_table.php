<?php
//generate:resource performedwork_featured --fields="performedwork_id:integer, featured_order:integer"
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePerformedworkFeaturedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('performedwork_featureds', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('performedwork_id');
			$table->integer('featured_order');
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
		Schema::drop('performedwork_featureds');
	}

}
