<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalsolicitudestramite.
 *
 * @package namespace App\Entities;
 */
class Portalsolicitudestramite extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "db_portal";

    protected $fillable = ['id_transaccion_motor','estatus','json_envio','json_recibido'];

    protected $table = "solicitudes_tramite";

}
