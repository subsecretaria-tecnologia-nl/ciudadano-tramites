<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePortalcamporelationshipsTable.
 */
class CreatePortalcamporelationshipsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.campos_relationship', function(Blueprint $table) {
            $table->increments('id');
						$table->integer('tramite_id');
            $table->integer('campo_id');
            $table->integer('tipo_id');
            $table->text('caracteristicas');
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
		Schema::drop('portal.campos_relationship');
	}
}
