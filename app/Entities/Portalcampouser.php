<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalcampouser.
 *
 * @package namespace App\Entities;
 */
class Portalcampouser extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tramite_id','usuario_id','campo_id','valor'];

    protected $table = "campos_user";

}
