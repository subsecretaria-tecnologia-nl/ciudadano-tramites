<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePortalsolicitudescatalogosTable.
 */
class CreatePortalsolicitudescatalogosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.solicitudes_catalogo', function(Blueprint $table) {
            $table->increments('id');
						$table->integer('tramite_id');
            $table->integer('padre_id');
            $table->string('titulo',200);
            $table->text('atendido_por');
            $table->integer('status');
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
		Schema::drop('portal.solicitudes_catalogo');
	}
}
