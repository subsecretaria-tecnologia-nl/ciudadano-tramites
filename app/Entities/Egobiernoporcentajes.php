<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernoporcentajes.
 *
 * @package namespace App\Entities;
 */
class Egobiernoporcentajes extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "db_egobierno";
     protected $table = "porcentajes";

 	   public $timestamps = false;

}
