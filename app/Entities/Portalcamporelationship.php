<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalcamporelationship.
 *
 * @package namespace App\Entities;
 */
class Portalcamporelationship extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $connection = "db_portal";

    protected $fillable = ['id','tramite_id','campo_id','tipo_id','caracteristicas', 'orden', 'agrupacion_id'];

    protected $table = "campos_relationship";

}
