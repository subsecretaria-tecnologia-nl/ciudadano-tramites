<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcampotypeRepository;
use App\Entities\Portalcampotype;
use App\Validators\PortalcampotypeValidator;

/**
 * Class PortalcampotypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcampotypeRepositoryEloquent extends BaseRepository implements PortalcampotypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcampotype::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
