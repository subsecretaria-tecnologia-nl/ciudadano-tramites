<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalsolicitudescatalogoRepository;
use App\Entities\Portalsolicitudescatalogo;
use App\Validators\PortalsolicitudescatalogoValidator;

/**
 * Class PortalsolicitudescatalogoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalsolicitudescatalogoRepositoryEloquent extends BaseRepository implements PortalsolicitudescatalogoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalsolicitudescatalogo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
