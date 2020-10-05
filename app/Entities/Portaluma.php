<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portaluma.
 *
 * @package namespace App\Entities;
 */
class Portaluma extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "db_operacion";

     protected $fillable = ['id','daily','monthly','yearly','year'];

     protected $table = "oper_uma_history";

}
