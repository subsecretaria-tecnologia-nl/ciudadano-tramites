<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernopartidas.
 *
 * @package namespace App\Entities;
 */
class Egobiernopartidas extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "db_egobierno";

    protected $fillable = ['id_servicio','id_partida','descripcion'];

    protected $table = "partidas";

	public $timestamps = false;
}
