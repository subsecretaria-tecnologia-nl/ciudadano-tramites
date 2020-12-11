<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernodiasferiados.
 *
 * @package namespace App\Entities;
 */
class Egobiernodiasferiados extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "db_egobierno";

     protected $fillable = ['Ano', 'Mes', 'Dia'];

     protected $table = "diasferiados";

 	   public $timestamps = false;

}
