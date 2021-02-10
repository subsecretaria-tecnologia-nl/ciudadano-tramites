<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Inpc.
 *
 * @package namespace App\Entities;
 */
class Inpc extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "db_operacion";

     protected $fillable = ['id','ano','mes','indice'];

    protected $table = "oper_inpc";

}
