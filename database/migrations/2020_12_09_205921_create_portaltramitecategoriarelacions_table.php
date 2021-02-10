<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePortaltramitecategoriarelacionsTable.
 */
class CreatePortaltramitecategoriarelacionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portaltramitecategoriarelacions', function(Blueprint $table) {
            $table->increments('id');
						$table->integer('categorias_id');
						$table->integer('tramite_id');
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
		Schema::drop('portaltramitecategoriarelacions');
	}
}
