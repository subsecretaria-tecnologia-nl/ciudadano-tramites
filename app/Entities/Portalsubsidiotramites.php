<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalsubsidiotramites.
 *
 * @package namespace App\Entities;
 */
class Portalsubsidiotramites extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "db_operacion";

    protected $fillable = ['id','tramite_id','costo_id','cuotas','limite_cuotas','id_partida', 'oficio','tipoPersona'];

    protected $table = "portal_sub_tramites";
}
