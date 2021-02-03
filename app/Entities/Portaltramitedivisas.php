<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portaltramitedivisas.
 *
 * @package namespace App\Entities;
 */
class Portaltramitedivisas extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "db_portal";

     protected $fillable = ['id','tramite_id'];

     protected $table = "tramites_divisas";

}
