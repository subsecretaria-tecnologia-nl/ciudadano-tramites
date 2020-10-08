<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernotiposervicios.
 *
 * @package namespace App\Entities;
 */
class Egobiernotiposervicios extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "db_egobierno";
     //protected $connection = "db_operacion";

     protected $fillable = ['Tipo_Code','Tipo_Descripcion','Origen_URL','GpoTrans_Num','id_gpm','descripcion_gpm','tiporeferencia_id','limitereferencia_id'];

     protected $table = "tipo_servicios";

}
