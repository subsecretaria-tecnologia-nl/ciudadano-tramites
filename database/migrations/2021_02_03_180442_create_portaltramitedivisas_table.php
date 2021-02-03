<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePortaltramitedivisasTable.
 */
class CreatePortaltramitedivisasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portaltramitedivisas', function(Blueprint $table) {
            $table->increments('id');
						$table->string('tramite_id',200);
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
		Schema::drop('portaltramitedivisas');
	}
}
