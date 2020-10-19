<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePortalcampousersTable.
 */
class CreatePortalcampousersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.campos_user', function(Blueprint $table) {
            $table->increments('id');
						$table->integer('tramite_id');
            $table->integer('usuario_id');
            $table->integer('campo_id');
            $table->string('valor',200);
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
		Schema::drop('portal.campos_user');
	}
}
