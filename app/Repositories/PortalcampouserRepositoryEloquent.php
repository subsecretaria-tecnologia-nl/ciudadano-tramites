<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcampouserRepository;
use App\Entities\Portalcampouser;
use App\Validators\PortalcampouserValidator;

/**
 * Class PortalcampouserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcampouserRepositoryEloquent extends BaseRepository implements PortalcampouserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcampouser::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
