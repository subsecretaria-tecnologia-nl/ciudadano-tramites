<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalsubsidiotramitesRepository;
use App\Entities\Portalsubsidiotramites;
use App\Validators\PortalsubsidiotramitesValidator;

/**
 * Class PortalsubsidiotramitesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalsubsidiotramitesRepositoryEloquent extends BaseRepository implements PortalsubsidiotramitesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalsubsidiotramites::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
