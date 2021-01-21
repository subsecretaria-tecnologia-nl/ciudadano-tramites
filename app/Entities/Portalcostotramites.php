<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalcostotramites.
 *
 * @package namespace App\Entities;
 */
class Portalcostotramites extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "db_operacion";

    protected $fillable =['id','tramite_id','tipo','tipo_costo_fijo','costo', 'costo_fijo','minimo','maximo','valor','variable','var_minimo', 'var_valor','porcentaje','status'];

    protected $table = "portal_costo_tramites";
}
