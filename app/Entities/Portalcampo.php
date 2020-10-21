<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalcampo.
 *
 * @package namespace App\Entities;
 */
class Portalcampo extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "db_portal";

    protected $fillable = ['status','descripcion'];

    protected $table = "campos_catalogue";

}
