<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcostotramitesRepository;
use App\Entities\Portalcostotramites;
use App\Validators\PortalcostotramitesValidator;

/**
 * Class PortalcostotramitesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcostotramitesRepositoryEloquent extends BaseRepository implements PortalcostotramitesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcostotramites::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
