<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePortaltramitecategoriasTable.
 */
class CreatePortaltramitecategoriasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tramites_categorias', function(Blueprint $table) {
            $table->increments('id');
						$table->string('descripcion',200);
						$table->integer('status_id');
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
		Schema::drop('tramites_categorias');
	}
}
