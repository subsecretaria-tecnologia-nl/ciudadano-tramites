<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalsolicitudesticket.
 *
 * @package namespace App\Entities;
 */
class Portalsolicitudesticket extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "db_portal";

    protected $fillable = [];

    protected $table = "solicitudes_ticket";

}
