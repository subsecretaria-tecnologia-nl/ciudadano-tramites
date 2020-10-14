<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Tramitedetalle.
 *
 * @package namespace App\Entities;
 */
class Tramitedetalle extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "db_operacion";

    protected $fillable = ['id_detalle_tramite','id_tramite_motor','concepto','importe_concepto','partida'];

    protected $table = "oper_detalle_tramite";

}
