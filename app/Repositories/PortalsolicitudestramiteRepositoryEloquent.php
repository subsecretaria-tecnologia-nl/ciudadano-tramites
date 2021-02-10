<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalsolicitudestramiteRepository;
use App\Entities\Portalsolicitudestramite;
use App\Validators\PortalsolicitudestramiteValidator;

/**
 * Class PortalsolicitudestramiteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalsolicitudestramiteRepositoryEloquent extends BaseRepository implements PortalsolicitudestramiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalsolicitudestramite::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
