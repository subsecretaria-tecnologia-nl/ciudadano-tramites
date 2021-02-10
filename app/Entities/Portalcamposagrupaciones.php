<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalcamposagrupaciones.
 *
 * @package namespace App\Entities;
 */
class Portalcamposagrupaciones extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "db_portal";

    protected $fillable = ['descripcion','id_tramite', 'id_categoria'];

     protected $table = "campos_agrupaciones";
}
