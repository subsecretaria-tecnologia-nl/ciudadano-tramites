<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalsolicitudesticketRepository;
use App\Entities\Portalsolicitudesticket;
use App\Validators\PortalsolicitudesticketValidator;

/**
 * Class PortalsolicitudesticketRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalsolicitudesticketRepositoryEloquent extends BaseRepository implements PortalsolicitudesticketRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalsolicitudesticket::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
