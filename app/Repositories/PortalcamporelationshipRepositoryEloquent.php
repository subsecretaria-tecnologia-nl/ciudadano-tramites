<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcamporelationshipRepository;
use App\Entities\Portalcamporelationship;
use App\Validators\PortalcamporelationshipValidator;

/**
 * Class PortalcamporelationshipRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcamporelationshipRepositoryEloquent extends BaseRepository implements PortalcamporelationshipRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcamporelationship::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
