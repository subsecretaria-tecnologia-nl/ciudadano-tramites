<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalsolicitudescatalogo.
 *
 * @package namespace App\Entities;
 */
class Portalsolicitudescatalogo extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $connection = "db_portal";

    protected $fillable = ['tramite_id','padre_id','titulo','atendido_por','status'];

    protected $table = "solicitudes_catalogo";

}
