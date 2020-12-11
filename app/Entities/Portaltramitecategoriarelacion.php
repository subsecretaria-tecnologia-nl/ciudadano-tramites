<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portaltramitecategoriarelacion.
 *
 * @package namespace App\Entities;
 */
class Portaltramitecategoriarelacion extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['categorias_id', 'tramite_id'];

     protected $connection = "db_portal";

     protected $table = "tramites_categorias_relacion";

}
